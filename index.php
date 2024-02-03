<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 , shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="style.css">
    
    <title>B_Inventory Web-App</title>
</head>
<body>
    

    
        <div class="content">
            <div>
            <img src="App/images/avatar.jpg" alt="Avatar" class="avatar">
            </div>
       
            <header>LOGIN</header>  
            
            <form method="post" action="app/model/login_db.php" autocomplete="off">
                <div class="field  space">
                    <span class="fa fa-user"></span>
                    <input type="text" required placeholder="Username" name="username">
                </div>
                <div class="field">
                    <span class="fa fa-lock"></span>
                    <input type="password" required placeholder="Password" name="password"  class="password">
                    <span class="show">SHOW</span>
                </div>
                
            <div class="g-recaptcha" data-sitekey="6Lcua_sgAAAAAPQIoJjICPBuhv2wPVOB7Oyx3-xR" ></div><br>
                
                
                <div class="field">
                    
                    <input type="submit" name="login" value="LOGIN" class="login_btn">
                    
                </div>
                
           
                <script>
                    const pass_field = document.querySelector('.password');
                    const show_btn = document.querySelector('.show');
                    show_btn.addEventListener('click',function(){
                        if(pass_field.type==="password"){
                            pass_field.type="text";
                            show_btn.textContent="HIDE";
                        }else{
                            pass_field.type="password"; 
                            show_btn.textContent="SHOW";
                        }

                    });
                </script>
               
            </form>
            
            
        </div>
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>