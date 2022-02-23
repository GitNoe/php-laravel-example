<x-layout>
    <div>
        <h1>Página Principal de Posts</h1>
    </div>
    <div class="grid-container">
        @foreach ($posts as $post)

        <article>
            <h2>
                <a href="/posts/{{ $post->slug }}">
                    {!! $post->title !!}
                </a>
            </h2>

            <p>
                <!-- <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a> -->
                By <a href="/authors/{{ $post->author->username }}">{{ $post->author->name }}</a> in <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
            </p>

            <div>
                <p>{{ $post->excerpt }}</p>
            </div>
        </article>

        @endforeach
    </div>
</x-layout>
