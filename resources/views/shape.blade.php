<html>
<head>
    <title>Shape api sending form</title>
</head>

<body>
    <h3>Here's a testing form to request shapes</h3>
    <form method="post" action="{{route('shape.draw')}}">

        <textarea name="data" cols="100" rows="20">{
    "shapes": [
        {
            "type": "circle",
            "perimeter": 500,
            "color": "green",
            "border": {
                "color": "red",
                "width": 10
            }
        },
        {
            "type": "square",
            "sideLength": 175,
            "color": "rgb(255, 255, 0)",
            "border": {
                "color": "#776cff",
                "width": 2
            }
        }
    ]
}</textarea>

        <br>
        <button type="submit">Request shapes</button>
    </form>
</body>
</html>