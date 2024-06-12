<?php
session_start();
include('../common/databaseconn.php');
include('../common/profileupload.php');
include('../common/mainpageheader.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Community</title>
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes colorChange {
            0% {color: #ff6347;}
            25% {color: #32cd32;}
            50% {color: #1e90ff;}
            75% {color: #ff1493;}
            100% {color: #ff6347;}
        }
    </style>
</head>
<body style="font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #f0f4f7, #d9e8f5); margin: 0; padding: 0; overflow-x: hidden;">
    <div style="max-width: 1200px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);">
        <div style="text-align: center; font-size: 28px; color: #007bff; margin: 20px 0; animation: fadeInDown 2s;">
            Welcome to the ConnectVerse Community!
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 24px; color: #333; animation: colorChange 4s infinite;">Community</h1>
            <button style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" 
                    onclick="alert('Add Topic Button Clicked!')" 
                    onmouseover="this.style.transform='scale(1.05)'" 
                    onmouseout="this.style.transform='scale(1)'">Add Topic</button>
        </div>

        <div style="background-color: #f4f4f4; border-radius: 5px; padding: 20px; margin-bottom: 20px; animation: slideInLeft 1.5s;">
            <h2 style="font-size: 22px; color: #ff6347; margin-bottom: 10px;">Trending Topics</h2>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2s;">What's the best programming language in 2024?</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.2s;">Top 10 Tips for Remote Working</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.4s;">How to stay motivated while coding?</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.6s;">AI and Machine Learning Trends</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.8s;">Best practices for web development</div>
        </div>

        <div style="background-color: #f4f4f4; border-radius: 5px; padding: 20px; margin-bottom: 20px; animation: slideInRight 1.5s;">
            <h2 style="font-size: 22px; color: #32cd32; margin-bottom: 10px;">Popular Categories</h2>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2s;">Technology</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.2s;">Health & Wellness</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.4s;">Education</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.6s;">Lifestyle</div>
            <div style="color: #007bff; margin-bottom: 5px; cursor: pointer; animation: fadeIn 2.8s;">Entertainment</div>
        </div>

        <div style="background-color: #e6f7ff; border-radius: 5px; padding: 20px; margin-bottom: 20px; animation: fadeIn 1s; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h2 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 10px;">Topic 1</h2>
            <p style="color: #555;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu magna quis quam fermentum lobortis.</p>
            <p style="margin-top: 10px; color: #777;">Posted by: John Doe</p>
        </div>

        <div style="background-color: #e6f7ff; border-radius: 5px; padding: 20px; margin-bottom: 20px; animation: fadeIn 1s; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h2 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 10px;">Topic 2</h2>
            <p style="color: #555;">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
            <p style="margin-top: 10px; color: #777;">Posted by: Jane Doe</p>
        </div>

        <!-- More topics can be added here -->
    </div>
<?php  
include('../common/footers.php');
?>
</body>
</html>
