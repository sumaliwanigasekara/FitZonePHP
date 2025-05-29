<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   
        
    <title>FitZone Fitness Center</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

    :root{
        --primaryC1: #ff914d;
        --primaryC2: #FFA630;
        --primaryC3: #003366;
        --primaryC4: #0474BA;
        --primaryC5: #00A7E1;
        --background-color1: #524f4f;
        --background-color2: #0c0c0c;
        --background-color3: #EBEBEB;
    }

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
        list-style: none;
        border: none;
        outline: none;
        scroll-behavior: smooth;
        font-family: "Nunito", sans-serif;
    }

    html{
        font-size: 20px;
        overflow-x: hidden;
    }

    body {
        background: var(--background-color1);
        color: var(--background-color3);            
    }

    section{
        min-height: 100vh;
        padding: 200px 8% 30px;
    }

    .header {
        position: fixed;
        width: 100%;
        top: 0;
        right: 0;
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5%;
        background: transparent;
        backdrop-filter: blur(10px);
        transition: all 0.5s ease;
        height: 100px;
        box-sizing: border-box;
    }

    img{
        height: 100px;
        width: 180px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    img:hover{
        transform: scale(1.2);
    }

    .logo{
        font-size: 40px;
        color: var(--primaryC3);
        margin-left: 0;
        font-weight: 800;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .logo:hover{
        transform: scale(1.1);
    }

    span{
        color: var(--primaryC1);
    }

    .navbar{
        display: flex;
    }

    .navbar a{
        font-size: 20px;
        font-weight: 500;
        color: var(--background-color3);
        margin-left: 30px;
        gap: 10px;
        transition: all 0.5s ease;
        border-bottom: 3px solid transparent;
    }

    .navbar a:hover,
    .navbar a.active{
        color: var(--primaryC1);
        border-bottom: 3px solid var(--primaryC1);
    }

    .nav-buttons{
        display: flex;
        gap: 10px;
    }

    .nav-btn{
        padding: 8px, 20px;
        border-radius: 5px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .nav-btn-register {
        display: inline-block;
        padding: 10px 20px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: 2px solid var(--primaryC1);
        border-radius: 7px;
        font-size: 18px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.5s ease;
        min-width: max-content;
    }

    .nav-btn-login{
        display: inline-block;
        padding: 10px 30px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: 2px solid var(--primaryC1);
        border-radius: 7px;
        font-size: 18px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.5s ease;
        min-width: max-content;
    }

    .nav-btn-login:hover,
    .nav-btn-register:hover{
        color: var(--background-color2);
        box-shadow: 0 0 18px var(--primaryC1);
    }

    #menu-icon{
        font-size: 25px;
        color: var(--primaryC1);
        cursor: pointer;
        display: none;
    }
  
    .home {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0.2)), 
        url(assets/vecteezy_man-holding-a-dumbbell-in-a-gym-with-row-of-dumbbells-in-the_2029070.jpg) no-repeat center center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 120px 90px;
        color: var(--background-color3);
        box-sizing: border-box;
        min-height: 100vh;
        text-align: center;
    }

    .home-content {
        max-width: 800px;
        font-size: 35px;
        font-weight: 600;
        text-align: center;
    }

    .home-content h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .home-content h2 {
        font-size: 2rem;
        color: var(--primaryC3);
        margin-bottom: 20px;
    }

    .home-content p {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.2rem;
        margin: 20px 0;
        padding: 0 20px;
        font-weight: bold;
    }

   
    @media (max-width: 992px) {
        .home {
            padding: 100px 50px;
        }

        .home-content h1 {
            font-size: 2.5rem;
        }

        .home-content h2 {
            font-size: 1.8rem;
        }

        .home-content p {
            font-size: 1rem;
            padding: 0 15px;
        }
    }

    @media (max-width: 768px) {
        .home {
            padding: 80px 30px;
            text-align: center;
        }

        .home-content h1 {
            font-size: 2rem;
        }

        .home-content h2 {
            font-size: 1.5rem;
        }

        .home-content p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .home {
            padding: 60px 20px;
        }

        .home-content h1 {
            font-size: 1.8rem;
        }

        .home-content h2 {
            font-size: 1.2rem;
        }

        .home-content p {
            font-size: 0.8rem;
        }
    }

    .programs{
        background: linear-gradient(to right,rgba(0, 0, 0, 1), rgba(0, 0, 0, 0.2)), 
        url(assets/pexels-anush-1229356.jpg) no-repeat center center/cover;
    }

    .schedule{
        color: var(--primaryC1);
    }

    .heading{
        text-align: center;
        font-size: 40px;
        color: var(--primaryC1);
        margin-top: 50px;
    }

    .programs-content{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        align-items: center;
        gap: 30px;
        color: var(--background-color3);
    }

    .row{
        background-color: var(--background-color2);
        border-radius: 25px;
        border: 1px solid transparent;
        transition: all 0.5s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        min-height: 400px;
    }

    .row img{
        height: 200px;
        width: 100%;
        border-radius: 27px;
        margin-bottom: 20px;
        transition: all 0.5s ease;
        object-fit: cover;
    }

    .row h4{
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.4;
        transition: all 0.5s ease;
    }

    .row .description{
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: var(--background-color1);
        color: var(--background-color3);
        padding: 20px;
        box-sizing: border-box;
        border-radius: 27px;
        transition: all 0.5s ease;
        opacity: 0;
    }

    .row:hover{
        border: 4px solid var(--primaryC1);
        cursor: pointer;
    }

    .row:hover img{
        transform: scale(1.1);
    }

    .row:hover h4{
        color: var(--primaryC1);
    }

    .row:hover .description{
        top: 0;
        opacity: 1;
    }

    .about{
        display: flex;
        text-align: left;
        flex-direction: column;
        align-items: center;
        background: var(--background-color2);
        color: var(--background-color3);
    }

    .about-wrapper{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: flex start;
        gap: 40px;
        margin: 0 auto;
    }

    .about-content{
        max-width: 800px;
        flex: 1;
    }

    .about-content h3 {
        font-size: 28px;
        color: var(--primaryC1);
        margin-bottom: 15px;
    }

    .about-content p {
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 20px;
        color: var (--background-color3);
    }

    .about-content ul {
        list-style-type: disc;
        margin-left: 20px;
        margin-bottom: 20px;
    }

    .about-content ul li {
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .prog-content {
        display: flex;
        justify-content: center;
        background: var(--background-color2);
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .col{
        background-color: var(--background-color1);
        border-radius: 27px;
        border: 1px solid transparent;
        padding: 20px;
        transition: all 0.5s ease;
        text-align: center;
        width: 300px;
        flex: 1 1 300px;
        margin: 10px;
    }

    .col img{
        height: 250px;
        width: 100%;
        border-radius: 27px;
        margin-bottom: 20px;
        object-fit: cover;
    }

    .col h4{
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
        color: white;
    }

    .col:hover{
        border: 4px solid var(--primaryC1);
        cursor: pointer;
    }

    .button,
    .btn-more, .btn-less,
    .btn-review{
        padding: 5px;
        background: var(--primaryC1);
        outline: none;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        color: var(--background-color3);
        text-decoration: none;
        font-size: 20px;
        
    }

    .slider {
        border-radius: 25px;
        position: relative;
        height: 500px;
        width: 800px;
        overflow: hidden;
    }

    .slider img {
        position: absolute;
        height: 500px;
        width: 800px;
        opacity: 0;
        animation: fade 40s infinite;
    }

    #slide1 { animation-delay: 0s; }
    #slide2 { animation-delay: 5s; }
    #slide3 { animation-delay: 10s; }
    #slide4 { animation-delay: 15s; }
    #slide5 { animation-delay: 20s; }
    #slide6 { animation-delay: 25s; }
    #slide7 { animation-delay: 30s; }
    #slide8 { animation-delay: 35s; }

    @keyframes fade {
        0% { opacity: 0; }
        5% { opacity: 1; }
        20% { opacity: 1; }
        25% { opacity: 0; }
        100% { opacity: 0; }
    }

    label {
        display: block;
        text-align: left;
        margin-top: 10px;
    }

    .packages{
        position: relative;
        z-index: 1;
        color: var(--background-color3);
        padding: 50px 20px;
        text-align: center;
    }

    .background-video{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
        opacity: 1;
    }

    .packages-content{
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, auto));
        gap: 20px;
        margin-top: 20px;
    }

    .box{
        padding: 10px 10px 10 10px;
        height: 510px;
        background-color: var(--background-color2);
        border-radius: 28px;
        border: 1 px solid transparent;
        transition: all 0.5s ease;
        cursor: pointer;
        margin: 60px;
    }

    .box:hover{
        border: 2px solid var(--primaryC1);
        transform: translateY(-5);
    }

    .box h2{
        margin-bottom: 20px;
        color: var(--primaryC1) ;
    }

    .box h3{
        margin-bottom: 20px;
    }

    .box ul {
        list-style-type: disc;
        margin-left: 20px;
        margin-bottom: 20px;
    }

    .box ul li {
        font-size: 16px;
        line-height: 1.6;
        color: var(--background-color3);
    }

    .promotion {
        background: var(--primaryC1);
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .promotion p {
        font-size: 14px;
        color: var(--background-color3);
        margin: 0;
    }

    .box a{
        display: inline-block;
        color: var(--primaryC1);
        font-weight: 800;
        transition: all 0.5s ease;
    }

    .schedule{
        padding: 50px 8%;
        color: var(--background-color3);
    }

    .schedule-content{
        overflow-x: auto;
    }

    table{
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: var(--background-color2);
        border-radius: 10px;
        overflow: hidden;
    }

    table th, table td{
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid var(--primaryC1);
    }

    table th{
        background: var(--primaryC2);
        color: var(--background-color2);
        font-size: 18px;
        font-weight: 700;
    }

    table td{
        font-size: 16px;
        color: var(--background-color3);
    }

    table tr:hover{
        background: var(--primaryC1);
    }

    .blog{
        text-align: flex;
        padding: 100px 20px;
        background: linear-gradient(to right,rgba(0, 0, 0, 1), rgba(0, 0, 0, 0.2)), 
        url(assets/anastase-maragos-9dzWZQWZMdE-unsplash.jpg) no-repeat center center;
        
    }

    .blog-content{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 3fr));
        gap: 20px;
        padding: 20px;
    }

    .row-blog{
        background: var(--background-color2);
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 1);
        padding: 20px;
        position: relative;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .row-blog:hover{
        transform: scale(1.02);
    }

    .row-blog img{
        width: 450px;
        height: 300px;
        border-radius: 10px;
        transition: opacity 0.3s ease;
    }

    .row-blog:hover img{
        opacity: 0.3;
    }

    .blog-topic h4{
        margin: 15px 0;
        font-size: 25px;
    }

    .short-description{
        display: block;
    }

    .full-description{
        display: none;
        margin-top: 20px;
    }

    .button:hover{
        background-color: var(--primaryC3);
    }

    .review{
        background: var(--background-color2);
        align-items: center;  
    }

    .review-box{
        padding-top: 50px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .rating{
        color: var(--primaryC2);
    }

    .review-item{
        color: var(--background-color3);
        border-radius: 10px;
        width: 1200px;
        text-align: center;
    }

    .transform-content{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        justify-content: center;
        margin-top: 40px;
        padding: 20px;
    }

    .transform-box{
        background: var(--background-color2);
        padding: 30px;
        text-align: center;
        border-radius: 10px;
    }

    .transform-box img {
        width: 350px;
        height: 350px;
        border-radius: 10px;  
    }

    .transform-box h4 {
        margin-top: 10px;
        font-size: 18px;
        color: var(--background-color3);
    }

    .transform {
        font-size: 28px;
        color: var(--primaryC5);
        text-align: center;
        margin-top: 50px;
    }
        
    .footer{
        position: relative;
        bottom: 0;
        width: 100%;
        padding: 10px 0;
        background: transparent;
    }

    .footer .icon{
        text-align: center;
        padding-bottom: 10px;
    }

    .footer .icon a{
        font-size: 35px;
        color: var(--background-color3);
        border: 2px solid var(--primaryC1);
        width: 42px;
        height: 42px;
        line-height: 42px;
        display: inline-block;
        text-align: center;
        border-radius: 10px;
        margin: 0 5px;
        transition: 0.5s ease-in-out;
    }

    .footer .icon a:hover{
        transform: scale(1.1) translateY(-5px);
        background: var(--primaryC1);
        color: var(--background-color2);
    }

    .footer .copyright{
        margin-top: 5px;
        text-align: center;
        font-size: 16px;
        color: var (--background-color3);
    }

    .container-log{
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
        url(assets/pexels-cesar-galeao-1673528-3289711.jpg) no-repeat center center/cover;;
    }

    .container{
        position: relative;
        width: 70%;
        height: 700px;
        background: var(--background-color3);
        border-radius: 30px;
        overflow: hidden;
    }

    .form-box{
        position: absolute;
        right: 0;
        width: 50%;
        height: 100%;
        background: var(--primaryC1);
        display: flex;
        align-items: center;
        color: var(--primaryC3);
        text-align: center;
        padding: 40px;
        z-index: 1;
        transition: 0.6s ease-in-out 1.2s, visibility 0s 1s;
    }

    .container.active .form-box{
        right: 50%;
    }

    .form-box.register{
        visibility: hidden;
    }

    .container.active .form-box.register{
        visibility: visible;
    }

    form{
        width: 100%;
    }

    .container h1{
        font-size: 36px;
        margin: 10px 0;
    }

    .input-box{
        position: relative;
        margin: 30px 0;
    }

    .input-box input{
        width: 100%;
        padding: 13px 50px 13px 20px;
        background: var(--background-color3);
        border-radius: 8px;
        border: none;
        outline: none;
        font-size: 13px;
        color: var(--background-color1);
        font-weight: 500;
    }

    .input-box input::placeholder{
        color: var(--background-color1);
        font-weight: 400;
    }

    .input-box i{
        position: absolute;
        right: 20px;
        top: 60%;
        transform: translateY(-50%);
        font-size: 20px;
        color: var(--primaryC3);
    }

    .forgot-link{
        margin: -15px 0 15px;  
    }

    .forgot-link a{
        font-size: 14.5px;
        color: var(--primaryC4);
        text-decoration: none;
    }

    .btn-submit{
        width: 100%;
        height: 45px;
        background: var(--primaryC3);
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: var(--background-color3);
        font-weight: 700;
    }

    .container p{
        font-size: 14.5px;
        margin: 13px 0;
    }

    .icons a{
        display: inline-block;
        padding: 8px;
        border: 3px solid var(--background-color3);
        border-radius: 8px;
        font-size: 20px;
        color: var(--primaryC3);
        text-decoration: none;
        margin: 0 8px;
    }

    .btn-register{
        width: 100%;
        height: 48px;
        background: var(--primaryC3);
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: var(--background-color3);
        font-weight: 700;
    }

    .toggle-box{
        position: absolute;
        width: 100%;
        height: 100%;
        background: var(--primaryC1);
    }

    .toggle-box::before{
        content:'';
        position: absolute;
        left: -250%;
        width: 300%;
        height: 100%;
        background: var(--primaryC3);
        border-radius: 150px;
        z-index: 2;
        transition: 1.8s ease-in-out;
    }

    .container.active .toggle-box::before{
        left: 50%;
    }

    .toggle-panel{
        position: absolute;
        width: 50%;
        height: 100%;
        color: var(--background-color3);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 2;
        transition: 0.6s ease-in-out;
    }

    .toggle-panel.toggle-left{
        left: 0;
        transition-delay: 1.2s;
    }

    .container.active .toggle-panel.toggle-left{
        left: -50%;
        transition-delay: 0.6s;
    }

    .toggle-panel.toggle-right{
        right: -50%;
        transition-delay: 0.6s;
    }

    .container.active .toggle-panel.toggle-right{
        right: 0;
        transition-delay: 1.2s;
    }

    .toggle-panel p{
        margin-bottom: 20px;
    }

    .toggle-panel .btn{
        font-size: 20px;
        width: 160px;
        height: 46px;
        background: transparent;
        border: 3px solid var(--primaryC1);
        box-shadow: none;
        border-radius: 10px;
        color: var(--background-color3);
        cursor: pointer;
    }

    .form-box.register {
        display: none;
    }

    .container.active .form-box.register {
        display: flex;
    }

    .container.active .form-box.login {
        display: none;
    }

    @media (max-width: 1200px) {
    html {
        font-size: 18px;
    }
    
    .home-content p {
        padding-right: 300px;
    }
    
    .slider {
        width: 700px;
        height: 450px;
    }
    
    .slider img {
        width: 700px;
        height: 450px;
    }
}

@media (max-width: 992px) {

    #menu-icon {
        display: block;
        order: 1;
    }

    html {
        font-size: 16px;
    }
    
    .header {
        padding: 15px 5%;
    }
    
    .home-content p {
        padding-right: 200px;
    }
    
    .programs-content, .blog-content {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
    
    .slider {
        width: 600px;
        height: 400px;
    }
    
    .slider img {
        width: 600px;
        height: 400px;
    }
    
    .about-wrapper {
        flex-direction: column;
        align-items: center;
    }
    
    .container {
        width: 90%;
        max-width: 800px;
    }
}

@media (max-width: 800px) {
    .nav-btn-login,
    .nav-btn-register {
        display: none;
    }
}

@media (max-width: 768px) {
    
    #menu-icon {
        display: block;
    }
    
    .navbar {
        position: fixed;
        top: 100px;
        left: -100%;
        width: 100%;
        height: calc(100vh - 100px);
        background: var(--background-color2);
        flex-direction: column;
        align-items: center;
        padding: 40px 0;
        transition: all 0.5s ease;
        z-index: 999;
    }
    
    .navbar.active {
        left: 0;
    }
    
    .navbar a {
        margin: 15px 0;
        font-size: 1.2rem;
    }
    
    .nav-buttons {
        display: flex;
        flex-direction: column;
        width: 100%;
        padding: 0 20px;
        margin-top: 15px;
    }
    
    .nav-btn {
        width: 100%;
        margin: 5px 0;
        padding: 12px;
        text-align: center;
    }
    
    .home {
        padding: 150px 30px 50px;
        text-align: center;
    }
    
    .home-content {
        font-size: 1.8rem;
    }
    
    .home-content p {
        padding-right: 0;
        font-size: 1.1rem;
    }
    
    .about {
        padding: 100px 20px 50px;
    }
    
    .slider {
        width: 100%;
        height: auto;
        max-width: 500px;
    }
    
    .slider img {
        width: 100%;
        height: auto;
    }
    
    .prog-content {
        flex-direction: column;
        align-items: center;
    }
    
    .col {
        width: 100%;
        max-width: 400px;
    }
    
    .programs-content {
        grid-template-columns: 1fr;
        padding: 30px;
    }
    
    .packages-content {
        grid-template-columns: 1fr;
    }
    
    .box {
        margin: 20px 0;
        height: auto;
        padding-bottom: 30px;
    }
    
    .blog-content {
        grid-template-columns: 1fr;
    }
    
    .row-blog img {
        width: 100%;
        height: auto;
    }
    
    .review-item {
        width: 100%;
    }
    
    .transform-content {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .transform-box img {
        width: 100%;
        height: auto;
    }
    
    .container-log{
        padding: 60px 15px;
    }

    .container {
        height: auto;
        min-height: auto;
        flex-direction: column;
    }
    
    .form-box {
        position: relative;
        padding: 30px;
        width: 100%;
        height: auto;
        transition: none;
    }

    form-box.login,
    .form-box.register {
        display: block;
        visibility: visible;
        opacity: 1;
    }
    
    .toggle-box {
        display: none;
    }
    
    .container.active .form-box.login {
        display: none;
    }
    
    .container.active .form-box.register {
        display: flex;
    }

    .form-box h1::after {
        content: "Switch to " attr(data-other);
        display: block;
        font-size: 14px;
        margin-top: 10px;
        color: var(--primaryC3);
        cursor: pointer;
        text-decoration: underline;
    }
}

@media (max-width: 576px) {
    html {
        font-size: 14px;
    }
    
    section {
        padding: 120px 5% 30px;
    }
    
    .logo {
        font-size: 1.8rem;
    }
    
    img {
        height: 70px;
        width: 120px;
    }
    
    .home-content h1 {
        font-size: 2rem;
    }
    
    .home-content h2 {
        font-size: 1.5rem;
    }
    
    .heading {
        font-size: 1.8rem;
    }
    
    .slider {
        max-width: 100%;
    }
    
    .transform-content {
        grid-template-columns: 1fr;
    }
    
    .container-log {
        padding: 40px 15px;
    }
    
    .form-box {
        padding: 25px 15px;
    }
    
    .container h1 {
        font-size: 28px;
    }
    
    .input-box {
        margin: 20px 0;
    }
    
    .input-box input {
        padding: 12px 40px 12px 15px;
    }
    
    .btn-submit, .btn-register {
        height: 45px;
        font-size: 16px;
    }
}

@media (max-width: 400px) {
    .logo {
        font-size: 1.5rem;
    }
    
    .home-content h1 {
        font-size: 1.8rem;
    }
    
    .home-content p {
        font-size: 1rem;
    }
    
    .btn-query, .btn-more, .btn-less, .btn-review {
        font-size: 1rem;
        padding: 8px 15px;
    }
    
    .header {
        flex-wrap: wrap;
        height: auto;
        padding: 10px;
    }
    
    .logo {
        order: 1;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }
    
    #menu-icon {
        order: 2;
    }
    
    .nav-buttons {
        order: 3;
        width: 100%;
        margin-top: 10px;
    }
}

    
    </style>
</head>
<body>
    <header class="header">
        <img src="assets/LOGO.png" alt="">
        <a href="#home" class="logo">FitZone <span>Fitness</span></a>

        <div class="bx bx-menu" id="menu-icon"></div>

            <ul class="navbar" id="navbar">
                <li ><a id="active" href="#home">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#programs">Programs</a></li>
                <li><a href="#packages">Packages</a></li>
                <li><a href="blog.html" target="_blank">Blog</a></li>
                <li><a href="#reviews">Customer Stories</a></li>
            </ul>

            <div class="nav-buttons">
                <a href="#container-log" class="nav-btn nav-btn-login" data-target="login">Login</a>
                <a href="#container-log" class="nav-btn nav-btn-register" data-target="register">Join Now</a>
            </div>
        </nav>

    </header>

    <section class="home" id="home">

        <div class="home-content">
            <h1>IT'S ALL ABOUT</h1>
            <h1><span>WHAT YOU CAN ACHIEVE</span></h1>
            <h2>Empower yourself to make the change you need to make.</h2>
            <p>Welcome to FitZone Fitness Center, where we believe in empowering you to achieve your fitness goals. 
                Our state-of-the-art facilities, expert trainers, and personalized programs are designed to help you 
                transform your life. Join us today and take the first step towards a healthier, stronger you!</p>
        </div> 
    </section>
    
    <section class="about" id="about">
        <h2 class="heading">Why Choose Us?</h2>
            <div class="about-wrapper">
                <div class="about-content">
            
                    <h3>Our Vision</h3>
                    <p>To inspire and empower individuals to achieve their fitness goals through innovation, expert guidance, and a supportive community.</p>
                    <h3>Our Mission</h3>
                    <p>At FitZone Fitness Center, we are committed to providing a comprehensive and engaging fitness experience for all. Our mission is to:</p>
                    <ul>
                        <li>Offer state-of-the-art equipment and expert-led 
                            training programs.</li>
                        <li>Promote a culture of health, wellness, 
                            and personal growth.</li>
                        <li>Provide personalized
                             training and nutrition counseling tailored to individual needs.</li>
                        <li>Foster a welcoming environment 
                            where fitness goals become achievements.</li>
                    </ul>
                    <p>We, at FitZone Fitness Center are dedicated to delivering 
                    top-tier fitness services with a wide range of programs including Physical Fitness Training, Group Fitness Classes, cardio, Bodyweight Workouts, and Nutrition Councelling. 
                    We cater to individuals of all fitness levels. Our expert trainers, modern facilities, and interactive web-based application make fitness accessible, efficient, and engaging.</p>

              
                    <h3>Join Us Today!</h3>
                    <p>Whether you're looking to gain strength, lose weight, improve flexibility, or enhance overall fitness, FitZone Fitness Center is the ultimate destination for your wellness journey. </p>
                    <p>Join us today and experience the difference!</p>
                </div>
                <div class="Slider">
           
                    <img  id="slide1" src="assets/pexels-ketut-subiyanto-4720573.jpg">
                    <img  id="slide2" src="assets/pexels-cesar-galeao-1673528-3253498.jpg">
                    <img  id="slide3" src="assets/aqu.png">
                    <img  id="slide4" src="assets/cardio.png">
                    <img  id="slide5" src="assets/strengthtrain.png">
                    <img  id="slide6" src="assets//wo3.jpg">
                    <img  id="slide7" src="assets/wo2.jpg">
                    <img  id="slide8" src="assets/wo1.png">
             
                </div>
        
            </div>

            <h3>Meet Our Trainers</h3>
            <div class="prog-content">
                <div class="col">
                <img src="assets/trainer.png" alt="imgpg">

                <h4>Tharindu Perera – Head Trainer & Strength Coach</h4>
            </div>

            <div class="col">
                <img src="assets/trainergirl1.png" alt="imgpg">

                <h4>Nethmi Fernando – Group Fitness Coach</h4>
            </div>

            <div class="col">
                <img src="assets/trainer2.png" alt="imgpg">

                <h4>Dilan Silva – Cardio & Weight Loss Specialist</h4>
            </div>

            <div class="col">
                <img src="assets/anushka.png" alt="imgpg">

                <h4>Anushka Jayawardena – Nutrition & Wellness Coach</h4>
            </div>
      
    </section>

    <section class="programs" id="programs">
        <h2 class="heading">Our Programs</h2>

        <div class="programs-content">
            <div class="row">
                <img src="assets/pexels-timothy-220722-700446.jpg" alt="imgpg">

                <h4>Functional Training</h4>
                <div class="description">
                    <h4>Functional Training</h4>
                    <p>This type of workout focuses on movements that mimic everyday activities such as bending, lifting, reaching and twisting. 
                        These exercises involve multiple muscle groups and emphasize flexibility, balance and coordination. As you strengthen the muscles
                         used in daily tasks, you’ll find it easier to lift groceries, carry luggage or perform chores around the house.</p>
                    <p class="schedule">Everyday from 6AM to 8PM</p>
                </div>
            </div>

            <div class="row">
                <img src="assets/group.png" alt="imgpg">

                <h4>Group Fitness Classes - Yoga & Zumba</h4>
                <div class="description">
                    <h4>Group Fitness Classes - Yoga & Zumba</h4>
                    <p>If you thrive in social settings and prefer working out with others, Group Fitness Classes offer a fantastic opportunity to 
                        stay motivated while getting fit. Our Zumba, Yoga and Group Cycling provide a fun and energetic environment
                         to break a sweat.</p>
                        <p class="schedule">Zumba - Everyday from 5PM to 6PM || Yoga - Everyday from 7AM to 8AM</p>
                </div>
            </div>

            <div class="row">
                <img src="assets/pushup.png" alt="imgpg">

                <h4>BodyWeight Workouts</h4>
                <div class="description">
                    <h4>BodyWeight Workouts</h4>
                    <p>If you prefer working out without any equipment, our bodyweight workouts are a great option. These exercises utilize your 
                        body’s weight as resistance, making them convenient to do anywhere, anytime. Bodyweight workouts include push-ups, squats, 
                        lunges and planks. They help you build strength while improving your balance and flexibility.</p>
                    <p class="schedule">Everyday from 6AM to 8PM</p>
                </div>
            </div>

            <div class="row">
                <img src="assets/pexels-victorfreitas-841130.jpg" alt="imgpg">

                <h4>Strength Training</h4>
                <div class="description">
                    <h4>Strength Training</h4>
                    <p>Strength training involves exercises designed to increase your muscle strength and mass. 
                        This type of workout is crucial for overall functional fitness promoting muscle maintenance as you age. 
                        Bodyweight exercises like push-ups,
                         squats and planks are also effective for building strength. We at FitZone, incorporate various types of strength training into your fitness routine 
                         to increase your metabolic rate and improve your overall health.</p>
                    <p class="schedule">Everyday from 6AM to 8PM</p>
                </div>
            </div>

            <div class="row">
                <img src="assets/cardio.png" alt="imgpg">

                <h4>Cardiovascular Workouts</h4>
                <div class="description">
                    <h4>Cardiovascular Workouts</h4>
                    <p>Cardiovascular workouts, often referred to as cardio, focus on elevating your heart rate to enhance your cardiovascular 
                        endurance. These workouts are great for burning calories and improving lung capacity. We  offer many workouts like running, cycling, and jumping rope.
                         These activities get your heart pumping and help you shed
                          those extra pounds while boosting your energy levels.</p>
                    <p class="schedule">Everyday from 6AM to 8PM</p>
                </div>
            </div>

            <div class="row">
                <img src="assets/healthy.png" alt="imgpg">

                <h4>Nutrition Councelling</h4>
                <div class="description">
                    <h4>Nutrition Councelling</h4>
                    <p>When you weave an effective nutrition and fitness strategy into your fitness journey, you do more than just exercise – 
                        you enhance your life style. By encompassing both physical activity and nutrition guidance, with help of our professionals 
                        you can become the best you could ever be.</p>
                    <p class="schedule">Everyday from 6PM to 6.30PM</p>
                </div>
            </div>
        </div>

        
    </section>

    <section class="packages" id="packages">

        <video autoplay loop muted playsinline class="background-video">
            <source src="assets/5319759-uhd_3840_2160_25fps.mp4" type="video/mp4">
        </video>

        <h2 class="heading">Our Packages</h2>

        <div class= "packages-content">

        <div class="box">
            <h2>BASIC</h2>
            <h3>Day Pass - Rs.1500</h3>
            <ul>
                <li>General Gym Access</li>
                <li>Access to Cardio and Strength Equipment</li>
                <li>Locker and shower facilities</li>
                <li>Available from 7am-3pm</li>
            </ul>
            <div class="promotion">
                <p><strong>Special Promotion:</strong> Get 3 day passes just for Rs.4000</p>
            </div>
            <a href="#container-log" class="join-now" data-target="register">Join Now</a>
        </div>

        <div class="box">
            <h2>PRO</h2>
            <h3>Monthly Package - Rs.6000</h3>
            <ul>
                <li>General Gym Access</li>
                <li>Group Training Program</li>
                <li>Personal Training - 2 sessions per month</li>
                <li>Smart Workout Plan</li>
                <li>Access to all fitness classes</li>
                <li>Available from 7am-7pm</li>  
            </ul>
            <div class="promotion">
                <p><strong>Special Promotion:</strong> First month Rs.1000 off for new members!</p>
            </div>
            <a href="#container-log" class="join-now" data-target="register">Join Now</a>
        </div>

        <div class="box">
            <h2>COUPLE PACKAGE</h2>
            <h3>Monthly - Rs.10000</h3>
            <ul>
                <li>Everything in PRO Package</li>
                <li>Personal Training - 2 sessions per month for each</li>
                <li>Couple Fitness challenges and events</li>
                <li>Available from 7am-7pm</li>
            </ul>
            <div class="promotion">
                <p><strong>Special Promotion:</strong> Bring a friend and get 50% off the second membership!</p>
            </div>
            <a href="#container-log" class="join-now" data-target="register">Join Now</a>
        </div>

    
        <div class="box">
            <h2>PREMIUM</h2>
            <h3>Annual Package - Rs.70,000</h3>
            <ul>
                <li>Everything in PRO Package</li>
                <li>Personal Training - 4 sessions per month</li>
                <li>Nutrition Councelling - 2 sessions per month</li>
                <li>Exclusive access to VIP Lounge</li>
                <li>Free FitZone merchandise</li>
                <li>Available from 4am-12midnight</li>
            </ul>
            <div class="promotion">
                <p><strong>Special Promotion:</strong> Get 1st month free + a free fitness assessment!</p>
            </div>
            <a href="#container-log" class="join-now" data-target="register">Join Now</a>
    </div>

    </section>   

    

    <section class="review" id="reviews">
        
            <h2 class="heading">Client Stories</h2>

            <div class="review-box">

                <div class="review-item">
            
                <h2>Dinith Dissanayaka</h2>
                <div class="rating">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                </div>

                <p>One of the best fitness place I have ever been. Best place with amazing trainers.. Surportive, Friendly and knowledgeable guides ... Hoping to workout more with you all❤️ ️💪</p>

                </div>   

                <div class="review-item">
                    <h2>Safraz Mohammad</h2>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>

                    <p>Best place to go if you consider your fitness. The owner is well certified gym instructor. Custom made fitness schedule will be given for each member. Diet tips also given in order to achieve your fitness goal. Very friendly support instructors available including a lady fitness instructor. They will guide you and show you how to do technically correct work outs. There are lot of gym machines available. Car park also available in the rear. Fitness centre is open for 24 hrs (week days) as well.</p>
                    
                </div>

                <div class="review-item">
                    <h2>Janith Jeewantha</h2>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>

                    <p>Used this gym on a day membership (1500 Rupees). staff are great. Helped me figuring out the treadmill. Even gave directions to the gym from my home. Gym has A/C and a good vibe. The only minor issue is that treadmills have a time limit of 20 minutes. Although, I can understand the need for it, especially during peak times.</p>
                    
                </div>

                <div class="review-item">
                    <h2>Seha Karunarathne</h2>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>

                    <p>A fitness club with a vision, as I would like to call it. Maduranga, Fitness Chief, ensures that his clients are well trimmed and ready to lead a healthy life. Got a cheerful and helpful team to support on all aspects of fitness with thorough knowledge on the subject. Wanna look good, this is the place to be! Lets power up!</p>
            
                </div>

            </div>
        
            <h2 class="transform">Body Transformation with Fitzone Fitness</h2>
            <div class="transform-content">
                
            <div class="transform-box">
                <img src="assets/review1.png">
                <h4>2023 vs 2025</h4>
            </div>

            <div class="transform-box">
                <img src="assets/review2.png">
                <h4>2020 vs 2025</h4>
            </div>

            <div class="transform-box">
                <img src="assets/review3.png">
                <h4>2022 vs 2025</h4>
            </div>

            <div class="transform-box">
                <img src="assets/review4.png">
                <h4>2024 vs 2025</h4>
            </div>

        </div>
        
        
    </section>

    <section class="container-log" id="container-log">
        <div class="container">
            <div class="form-box login" id="login">
                <form action="">
                    <h1>LOGIN</h1>
                    <div class="input-box">
                        <input type="text" placeholder="Email" required>
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required>
                        <i class='bx bx-lock'></i>
                    </div>
                    <div class="forgot-link">
                        <a href="#">Forgot Password</a>
                    </div>
                    <button type="submit" class="btn-submit">Login</button>
                </form>
            </div>
            <div class="form-box register" id="register">
                <form id="registrationForm">
                    <h1>REGISTRATION</h1>
                    <div class="input-box">
                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="Full Name" required>
                        <i class='bx bx-user-circle'></i>
                    </div>
                    <div class="input-box">
                        <label>Contact Number</label>
                        <input type="text" name="phone" placeholder="Contact Number" required>
                        <i class='bx bx-phone'></i>
                    </div>
                    <div class="input-box">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" placeholder="Date of Birth" required>
                        <i class='bx bx-calendar'></i>
                    </div>
                    <div class="input-box">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bx-lock'></i>
                    </div>
                    <button type="submit" class="btn-register">Register</button>
                </form>
            </div>

            <div class="toggle-box">
                <div class="toggle-panel toggle-left">
                    <h1>Hello,Welcome!</h1>
                    <p>Don't have an account?</p>
                    <button class="btn register-btn">Register</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back!</h1>
                    <p>Already have an account?</p>
                    <button class="btn login-btn">Login</button>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">

            <div class="icon">
                <a href="https://wa.me/1234567890" target="_blank" aria-label="WhatsApp">
                    <i class='bx bxl-whatsapp' ></i>
                </a>
                <a href="https://www.instagram.com/fitzone" target="_blank" aria-label="Instagram">
                    <i class='bx bxl-instagram' ></i>
                </a>
                <a href="https://www.facebook.com/fitzone" target="_blank" aria-label="Facebook">
                    <i class='bx bxl-facebook-square' ></i>
                </a>
                <a href="mailto:info@fitzone.com" aria-label="Gmail">
                    <i class='bx bxl-gmail' ></i>
                </a>
                <a href="tel:+1234567890" aria-label="Telephone">
                    <i class='bx bx-phone' ></i>
                </a>
            </div>

            <p class="copyright">
                &copy;FitZone Fitness Center 2025 - All Rights Reserved
            </p>
        </footer>    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    //Navigation
    
    const menuIcon = document.querySelector('#menu-icon');
    const navbar = document.querySelector('.navbar');

    if (menuIcon && navbar) {
        menuIcon.addEventListener('click', () => {
            menuIcon.classList.toggle('bx-x');
            navbar.classList.toggle('active');
        });
    }

    // Close mobile menu when clicking on a nav link
    document.querySelectorAll('.navbar a').forEach(link => {
        link.addEventListener('click', () => {
            menuIcon.classList.remove('bx-x');
            navbar.classList.remove('active');
        });
    });

    //Login/Registration
    const container = document.querySelector('.container');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');

    // Toggle between login and registration forms
    if (registerBtn) {
        registerBtn.addEventListener('click', () => {
            container.classList.add('active');
        });
    }

    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            container.classList.remove('active');
        });
    }

    // Nav buttons to toggle forms
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            if (target === 'register') {
                container.classList.add('active');
            } else {
                container.classList.remove('active');
            }
            document.querySelector('.container-log').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Handle registration form submission
    const registerForm = document.querySelector('.form-box.register form');
    if (registerForm) {
document.getElementById('registrationForm').addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevent the default form submission

    const form = event.target;
    const formData = new FormData(form);

    // Convert form data to JSON
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    try {
        // Send the data to the server
        const response = await fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        // Check if the response is valid JSON
        const result = await response.json();
        console.log('Server Response:', result); // Log the server response for debugging

        if (result.success) {
            alert(result.message); // Show success message
            form.reset(); // Clear all fields
            container.classList.remove('active');
        } else {
            alert(result.message); // Show error message
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
})};

    // Handle login form submission
    const loginForm = document.querySelector('.form-box.login form');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            email: this.querySelector('input[type="text"]').value,
            password: this.querySelector('input[type="password"]').value
        };

        // Send data to PHP backend
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Perform the redirect
                window.location.href = data.redirect;
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during login.');
        });
    });
}

    //Query
    const queryModal = document.getElementById("queryModal");
    const queryBtn = document.querySelector(".btn-query");
    const closeQueryBtn = document.querySelector(".close");
    const queryForm = document.getElementById("queryForm");

    if (queryModal && queryBtn && closeQueryBtn && queryForm) {
        queryModal.style.display = "none";

        queryBtn.addEventListener("click", function(event) {
            event.preventDefault();
            queryModal.style.display = "flex";
        });

        closeQueryBtn.addEventListener("click", function() {
            queryModal.style.display = "none";
        });

        window.addEventListener("click", function(event) {
            if (event.target === queryModal) {
                queryModal.style.display = "none";
            }
        });

        queryForm.addEventListener("submit", function(event) {
            event.preventDefault();
            
            const formData = {
                name: this.querySelector('#name').value,
                contact: this.querySelector('#contact').value,
                email: this.querySelector('#email').value,
                description: this.querySelector('#description').value
            };

            // Send query data to PHP backend
            fetch('submit_query.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Thank you! Your query has been submitted.");
                    queryModal.style.display = "none";
                    queryForm.reset();
                } else {
                    alert("Error submitting query: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while submitting your query.");
            });
        });
    }

    //Package
    document.querySelectorAll('.join-now').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            if (target === 'register') {
                container.classList.add('active');
            }
            document.querySelector('.container-log').scrollIntoView({ behavior: 'smooth' });
        });
    });

    //Blog
    document.querySelectorAll('.btn-more').forEach(button => {
        button.addEventListener('click', function() {
            const blogItem = this.closest('.row-blog');
            blogItem.querySelector('.short-description').style.display = 'none';
            blogItem.querySelector('.full-description').style.display = 'block';
            this.style.display = 'none';
            blogItem.querySelector('.btn-less').style.display = 'inline-block';
        });
    });

    document.querySelectorAll('.btn-less').forEach(button => {
        button.addEventListener('click', function() {
            const blogItem = this.closest('.row-blog');
            blogItem.querySelector('.short-description').style.display = 'block';
            blogItem.querySelector('.full-description').style.display = 'none';
            this.style.display = 'none';
            blogItem.querySelector('.btn-more').style.display = 'inline-block';
        });
    });
});

    </script>

    
</body>


</html>