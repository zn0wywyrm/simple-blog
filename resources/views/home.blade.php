<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Daily Bugle</title>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            background-color: #ebf1fa;
        }
        h1 {
            text-align: center;
            font-size: 42px;
            margin-bottom: 8px;
        }

        header p {
            text-align: center;
            color: #555;
        }
        button {
            display: block;
            margin: 24px auto;
            padding: 12px 20px;
            background-color: #4b4dd1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        section {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        article {
            margin-top: 16px;
            padding: 16px;
            background-color: #f8faff;
            border: 1px solid #d6deeb;
            border-radius: 8px;
        }

        article h3 {
            margin-top: 0;
            color: #333;
        }

        article p {
            white-space: pre-wrap;
        }
    </style>
    <header>
        <h1>The Daily Bugle</h1>
        <p>Real stories. Real voices. Your city.</p>
    </header>

    <main>
        <button type="button" id="show-post-form">＋ Write a post</button>

        <form id="post-form" method="POST" action="{{ route('posts.store') }}" hidden>
            @csrf

            <label for="user-name">User name</label>
            <input id="user-name" name="user_name" type="text" required>

            <label for="blog-text">Blog</label>
            <textarea id="blog-text" name="blog_text" rows="6" required></textarea>

            <button type="submit">Publish</button>
        </form>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <section>
            <h2>Latest posts</h2>
            @if ($posts->isEmpty())
                <p>No posts yet. Be the first to share something!</p>
            @else
                @foreach ($posts as $post)
                    <article>
                        <h3>{{ $post->user_name }}</h3>
                        <p>{{ $post->blog_text }}</p>
                    </article>
                @endforeach
            @endif
        </section>
    </main>
    
    <script>
        const showPostFormButton = document.getElementById('show-post-form');
        const postForm = document.getElementById('post-form');

        showPostFormButton.addEventListener('click', function () {
            postForm.hidden = false;
        });
    </script>
</body>
</html>