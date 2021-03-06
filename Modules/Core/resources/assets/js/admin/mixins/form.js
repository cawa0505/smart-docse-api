import axios from 'axios'

export default {
  props: ['id', 'slug'],
  data () {
    return {
      showData: {},
      validation: {},
      pending: false
    }
  },
  computed: {
    isNew () {
      return this.id === undefined && this.slug === undefined
    }
  },
  methods: {
    async fetchData () {
      try {
        if (!this.isNew) {
          let {data} = await axios.get(this.$app.route(`admin.${this.resourceRoute}.show`, {
            [this.modelName]: this.id
          }))
          this.showData = data
          Object.keys(data).forEach((key) => {
            if (key in this.model) {
              this.model[key] = data[key]
            }
          })
          this.onModelChanged()
        }
      } catch (e) {
        throw e
      }
    },
    onModelChanged () {
    },
    feedback (name) {
      if (this.state(name)) {
        return this.validation.errors[name][0]
      }
    },
    state (name) {
      return this.validation.errors !== undefined && this.validation.errors.hasOwnProperty(name)
        ? 'invalid'
        : null
    },
    async onSubmit () {
      this.pending = true
      let router = this.$router
      let action = this.isNew ? this.$app.route(
        `admin.${this.resourceRoute}.store`) : this.$app.route(
        `admin.${this.resourceRoute}.update`, {[this.modelName]: this.id})

      let formData = this.$app.objectToFormData(this.model)

      if (!this.isNew) {
        formData.append('_method', 'PATCH')
      }

      try {
        let {data} = await axios.post(action, formData)
        this.pending = false

        this.$app.noty[data.status](data.message)
        if (this.listPath) {
          router.push(this.listPath)
        }
      } catch (e) {
        this.pending = false

        if (e.response.status === 422) {
          this.validation = e.response.data
          return
        }

        this.$app.error(e)
      }
    }
  },
  created () {
    this.fetchData()
  }
}
