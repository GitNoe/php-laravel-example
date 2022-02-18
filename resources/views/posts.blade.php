<x-layout>

    @foreach ($posts as $post)
        <article>
            <h2>
                <a href="/posts/{{ $post->slug }}">
                    {!! $post->title !!}
                </a>
            </h2>

            <p>
                <!-- <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a> -->
                <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
            </p>

            <div>
                {{ $post->excerpt }}
            </div>
        </article>
    @endforeach

</x-layout>
