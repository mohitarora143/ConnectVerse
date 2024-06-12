<?php
session_start();
include('../common/databaseconn.php');

// Check if the blog_id parameter is set in the URL
if(isset($_GET['blog_id'])) {
    // Retrieve the blog_id from the URL
    $blog_id = $_GET['blog_id'];

    // Prepare a SQL query to fetch the blog details using the blog_id
    $query = "SELECT * FROM blog_posts WHERE blog_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind the parameter
        $stmt->bind_param("i", $blog_id);

        // Execute the query
        $stmt->execute();

        // Store the result
        $result = $stmt->get_result();

        // Check if a blog was found
        if ($result->num_rows > 0) {
            // Fetch the blog details
            $blog = $result->fetch_assoc();

            // Close the statement
            $stmt->close();
        } else {
            // Blog not found
            $blog = false;
        }
    } else {
        // Error in preparing the statement
        echo "Error: Unable to prepare SQL statement.";
        exit; // Stop further execution
    }
} else {
    // blog_id parameter not set in the URL
    echo "Error: No blog ID provided.";
    exit; // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Details</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background: linear-gradient(to bottom, #87CEFA, #00BFFF);">

<div class="container" style="max-width: 800px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 20px;border:2px solid blue; box-shadow: 0 0 10px rgba(0, 0, 0, 0.9); position: relative;">
    <div class="close-btn" style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer; transition: transform 0.3s ease;" onclick="window.history.back();">
        &#10005;
    </div>
    <div class="blog-details" style="padding-top: 20px;">
        <h1 style="font-size: 28px; color: #333; margin-bottom: 10px; text-align: center; animation: fadeIn 1s ease; font-weight: bold;"><strong>Blog Title : </strong><?php echo $blog['title']; ?></h1>
        <img src="../Images/<?php echo $blog['featured_image']; ?>" alt="Blog Image" style="max-width: 100%; max-height:200px ;border-radius: 10px; margin: 0 auto 20px; display: block; text-align: center; position: relative; overflow: hidden; border: 2px dotted red; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);">

        <style>
            img::before,
            img::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border: 2px solid transparent;
                border-radius: 10px;
                animation-duration: 5s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }

            img::before {
                border-top-color: #fff;
                border-bottom-color: #fff;
                animation-name: rotateClockwise;
            }

            img::after {
                border-left-color: #fff;
                border-right-color: #fff;
                animation-name: rotateAntiClockwise;
            }

            @keyframes rotateClockwise {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }

            @keyframes rotateAntiClockwise {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(-360deg);
                }
            }

            p {
                color: #555;
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 15px;
                text-align: center;
                animation: slideInLeft 1s ease;
                font-weight: bold;
            }

            strong {
                color: #333;
            }
        </style>

        <p><?php echo $blog['content']; ?></p>
        <p><strong>Category:</strong> <?php echo $blog['category']; ?></p>
        <p><strong>Author:</strong> <?php echo $blog['author']; ?></p>
        <p><strong>Date Published:</strong> <?php echo date('F j, Y', strtotime($blog['date_published'])); ?></p>
        <p><strong>Status:</strong> <?php echo $blog['status'] ? 'Draft' : 'Published'; ?></p>
        <p><strong>Posted By:</strong> <?php echo $blog['username']; ?></p>
    </div>
</div>

<!-- Animated bubbles -->
<div class="background-bubbles" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;">
    <?php for ($i = 0; $i < 70; $i++) : ?>
        <div class="bubble" style="position: absolute; width: <?php echo rand(80, 90); ?>px; height: <?php echo rand(80, 90); ?>px; background-color: rgba(255, 255, 255, <?php echo (rand(50, 90) / 100); ?>); border-radius: 50%; animation: float <?php echo rand(5, 15); ?>s linear infinite; top: <?php echo rand(0, 100); ?>%; left: <?php echo rand(0, 100); ?>%;"></div>
    <?php endfor; ?>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-50px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(50px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-150px);
        }
        100% {
            transform: translateY(0);
        }
    }
</style>

</body>
</html>
