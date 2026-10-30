<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Site</title>
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
        form {
            margin: 24px 0;
            padding: 24px;
            background-color: white;
            border: 1px solid #d6deeb;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 14px;
            font-weight: bold;
        }

        input,
        textarea {
            box-sizing: border-box;
            width: 100%;
            margin-top: 6px;
            padding: 10px;
            border: 1px solid #aab3bd;
            border-radius: 5px;
            font: inherit;
        }

        form button {
            margin: 20px 0 0;
        }
        article time {
            color: #687386;
            font-size: 14px;
        }
        .post-preview {
            cursor: pointer;
        }

        .post-preview:hover {
            background-color: #eef3fc;
        }

        .post-preview-text {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        dialog {
            width: min(600px, calc(100% - 40px));
            max-height: 80vh;
            overflow-y: auto;
            border: 0;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 8px 30px #00000040;
        }

        dialog::backdrop {
            background-color: #00000080;
        }

        #close-post {
            margin-left: auto;
        }
    </style>
    <header>
        <h1>Blog Site</h1>
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
                    <article
                        class="post-preview"
                        tabindex="0"
                        role="button"
                        data-user="{{ $post->user_name }}"
                        data-date="{{ $post->created_at->format('M j, Y \a\t g:i A') }}"
                        data-text="{{ $post->blog_text }}"
                    >
                        <h3>{{ $post->user_name }}</h3>
                        <time>{{ $post->created_at->format('M j, Y \a\t g:i A') }}</time>
                        <p class="post-preview-text">{{ strtok($post->blog_text, "\n") }}</p>
                    </article>
                @endforeach

                <dialog id="post-popup">
                    <button type="button" id="close-post">Close</button>
                    <h2 id="popup-user"></h2>
                    <time id="popup-date"></time>
                    <p id="popup-text"></p>
                </dialog>
            @endif
        </section>
    </main>
    
    <script>
        const showPostFormButton = document.getElementById('show-post-form');
        const postForm = document.getElementById('post-form');

        showPostFormButton.addEventListener('click', function () {
            postForm.hidden = !postForm.hidden;
        });

        const postPopup = document.getElementById('post-popup');
        const popupUser = document.getElementById('popup-user');
        const popupDate = document.getElementById('popup-date');
        const popupText = document.getElementById('popup-text');

        document.querySelectorAll('.post-preview').forEach(function (post) {
            function openPost() {
                popupUser.textContent = post.dataset.user;
                popupDate.textContent = post.dataset.date;
                popupText.textContent = post.dataset.text;
                postPopup.showModal();
            }

            post.addEventListener('click', openPost);

            post.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openPost();
                }
            });
        });

        document.getElementById('close-post').addEventListener('click', function () {
            postPopup.close();
        });

        postPopup.addEventListener('click', function (event) {
            if (event.target === postPopup) {
                postPopup.close();
            }
        });
    </script>
</body>
</html>