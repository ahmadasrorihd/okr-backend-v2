<!DOCTYPE html>
<html>
    <head>
        <title>Hello jQuery</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>
        $(document).ready(function() {
            $.ajax({
                url: "banner/get_banner"
            }).then(function(s) {
            $('.greeting-id').append(s.id);
            $('.greeting-content').append(s.konten);
            });
        });
        </script>
    </head>

    <body>
        <div>
            <p class="greeting-id">The ID is </p>
            <p class="greeting-content">The content is </p>
        </div>
    </body>
</html>
