<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            display: block;
            padding: 50px 20px;
        }

        .container-visitor {
            background-color: white;
            max-width: 600px;
            margin: auto;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .accent-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .accent-icon .bar {
            width: 8px;
            height: 25px;
            background-color: #ff9933;
            margin-right: 4px;
            border-radius: 2px;
        }

        .accent-icon .bar:last-child {
            background-color: #00b2e3;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            color: #666;
            font-size: 12px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 14px;
        }

        textarea {
            height: 120px;
        }

        .name-group {
            display: flex;
            gap: 10px;
        }

        .name-group .form-group {
            flex: 1;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #1971c2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1565b0;
        }

        .success-message {
            display: none;
            text-align: center;
            color: #28a745;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!-- <div class="arc"></div> -->
    <div class="container-visitor">
        <div class="accent-icon">
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <h1>Got a question?</h1>
        <p class="subtitle">Fill in the form to get your answer</p>
        
        <form id="contactForm" method="POST" action="/visitor-query">
            <div class="name-group">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="district">District</label>
                <select id="district" name="district" required>
                    <option value="" disabled selected>Select your district</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Galle">Galle</option>
                    <option value="Jaffna">Jaffna</option>
                    <option value="Kandy">Kandy</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            
            <button type="submit">Submit</button>
            
            <div id="successMessage" class="success-message">
                Thank you! Your message has been submitted successfully.
            </div>
        </form>
    </div>
</body>
</html>
