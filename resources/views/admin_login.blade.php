<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: darkblue;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <input type="email" id="email" placeholder="Enter email">
        <input type="password" id="password" placeholder="Enter password">
        <button onclick="adminLogin()">Login</button>
        <p id="error-msg" style="color: red;"></p>
    </div>

    <script>
        function adminLogin() {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            fetch("http://127.0.0.1:8000/api/admin/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ email, password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    localStorage.setItem("adminToken", data.token);
                    window.location.href = "/admin";
// Redirect to admin panel
                } else {
                    document.getElementById("error-msg").innerText = data.error;
                }
            })
            .catch(error => {
                document.getElementById("error-msg").innerText = "Something went wrong!";
            });
        }
    </script>

</body>
</html>