<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Navigation</title>
    <style>
        * {
            font-family: sans-serif;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            background-color: black;
        }
        nav ul li {
            display: inline-block;
            position: relative;
        }
        nav ul li a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: yellow; /* Verander de achtergrondkleur bij hover */
            color: black; /* Verander de tekstkleur bij hover */
        }
        nav ul li ul {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
        }

        nav ul li:hover ul {
            display: block;
        }
        nav ul li ul li {
            display: block;
            white-space: nowrap;
        }

        nav ul li ul li a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
        }

        nav ul li ul li a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<nav>
     <ul>
        <li>
            <a href="#">ABOUT US &or;</a>
            <ul>
                <li><a href="#">Board</a></li>
                <li><a href="#">Mission</a></li>
                <li><a href="#">Team</a></li>
            </ul>
        </li>
            <li>
                <a href="#">PROGRAMS &or;</a>
                <ul>
                    <li><a href="#">Agriculture</a></li>
                    <li><a href="#">Education</a></li>
                    <li><a href="#">Health</a></li>
                    <li><a href="#">Humanitarian Work</a></li>
                </ul>
            </li>
            <li><a href="#">CULTURE</a></li>
            <li><a href="#">STORIES</a></li>
            <li><a href="#">SHOP</a></li>
            <li><a href="#">JOIN</a></li>
            <li><a href="#">DONATE</a></li>
        </ul>
</nav>

