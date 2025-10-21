<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{$post->commentCounts($post->id)}}</span>
            <!-- ポストModelの commentCounts/＄引数（どの投稿か）-->
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$post->likeCounts($post->id)}}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCounts($post->id) }}</span></p>
            <!-- ポストModelの likeCounts/＄引数（どの投稿か）-->
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4 ">
      <div class="posts-ber-btn-container">
        <a href="{{ route('post.input') }}" class="posts-ber-btn">投稿</a>
      </div>
      <div class="keyword-search">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest" class="keyword-ber">
        <input type="submit" value="検索" form="postSearchRequest" class="btn-search">
      </div>
      <div class="posts-good-mine">
        <input type="submit" name="like_posts" class="category_btn_good" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn_mine" value="自分の投稿" form="postSearchRequest">
      </div>
    </div>

  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"> </form>
</div>
</x-sidebar>
