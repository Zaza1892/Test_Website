<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
    <html lang="en">
      <head>
        <title>Sign Up Page</title>
        <link rel="stylesheet" href="styles.css" />
        <link
          href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
          rel="stylesheet"
        /> 
      </head>
      <body>
        <div class="signup-section">
        <form action="includes/signup_process.php" method="POST">
          <h1>Sign Up</h1>
          
          
            <label>First Name</label>
            <input type="text" name="username" placeholder="Name" required />
           
            <label>Email</label>
            <input type="email" name=email placeholder="Email"  required/>
            <label>Password</label>
            <input type="password" name=pwd placeholder="Password" required/>
           
            <input type="submit" value="Submit" />
          </form>
         
        </div>
        <p class="p2">
        Have an account? <a href="login.html">Login here</a>
        </p>
      </body>
    </html></span>
