<x-layout>

    <article>
        <h2>
            {!! $post->title !!}
        </h2>

        <p>
            By <a href="#">{{ $post->user->name }}</a> in <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
        </p>

        <div>
            {!! $post->body !!}
            <!-- las exclamaciones son para traducir el html puro -->
        </div>
    </article>

    <br>
    <a href="/">Go back</a>

</x-layout>
