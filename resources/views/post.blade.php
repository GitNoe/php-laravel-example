<x-layout>

    <article>
        <h2>
            {{ $post->title }}
        </h2>

        <div>
            {!! $post->body !!}
            <!-- las exclamaciones son para traducir el html puro -->
        </div>
    </article>

    <a href="/">Go back</a>

</x-layout>
