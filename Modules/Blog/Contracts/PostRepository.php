<?php

namespace Modules\Blog\Contracts;

use Modules\User\Models\User;
use Illuminate\Http\UploadedFile;
use Modules\Core\Contracts\BaseRepository;

/**
 * Interface PostRepository.
 */
interface PostRepository extends BaseRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function published();

    /**
     * @param \App\Models\Tag $tag
     *
     * @return mixed
     */
    public function publishedByTag(Tag $tag);

    /**
     * @param \Modules\User\Models\User $user
     *
     * @return mixed
     *
     * @internal param \App\Models\Tag $tag
     */
    public function publishedByOwner(User $user);

    /**
     * @param string $slug
     *
     * @return Post
     */
    public function findBySlug($slug);

    /**
     * @param \App\Models\Post              $post
     * @param array                         $input
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAndPublish(Post $post, array $input, UploadedFile $image = null);

    /**
     * @param Post                          $post
     * @param array                         $input
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAsDraft(Post $post, array $input, UploadedFile $image = null);

    /**
     * @param Post $post
     *
     * @return mixed
     */
    public function destroy(Post $post);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchPublish(array $ids);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchPromote(array $ids);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchPin(array $ids);
}
