<x-layout>
    <div>
        <h1>Página de Post Individual</h1>
    </div>
    <article>
        <h2>
            {!! $post->title !!}
        </h2>

        <p>
            By <a href="/authors/{{ $post->author->username }}">{{ $post->author->name }}</a> in <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
        </p>

        <div>
            <p>{!! $post->body !!}</p>
            <!-- las exclamaciones son para traducir el html puro -->
        </div>
    </article>

    <br>
    <a href="/">Go back</a>

</x-layout>
