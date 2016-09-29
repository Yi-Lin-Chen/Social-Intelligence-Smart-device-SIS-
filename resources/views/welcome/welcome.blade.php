@extends('welcome/layout')

@section('content')
<div id="main">
    <div class="inner">
        <header>
            <h1>Home Gateway Manager</h1>
            <p><b>Social Intelligence Smartlock And Sensor Control</b><p>
                User can use Facebook to login and request for permission. The System will automatically send a e-mail to notify the manager. The manager can then audit the user's identity. Once approved, the system will send the QRCode to user, the user can then unlock the door using the QRCode and access the sensor data.
            </p></p>
        </header>
        <section class="tiles">
            <article class="style1">
                <span class="image">
                    <img src="/img/pic01.jpg" alt="" />
                </span>
                <a href="/welcome/manager">
                    <h2>Notes to Manager</h2>
                    <div class="content">
                        <p>Introduce the basic processes and functions about the manager.</p>
                    </div>
                </a>
            </article>
            <article class="style2">
                <span class="image">
                    <img src="/img/pic02.jpg" alt="" />
                </span>
                <a href="/welcome/user">
                    <h2>Notes to User</h2>
                    <div class="content">
                        <p>Introduce the basic processes and functions about the user.</p>
                    </div>
                </a>
            </article>
            <article class="style3">
                <span class="image">
                    <img src="/img/pic03.jpg" alt="" />
                </span>
                <a href="/welcome/ourteam">
                    <h2>Our team</h2>
                    <div class="content">
                        <p>Introduce our team.</p>
                    </div>
                </a>
            </article>

        </section>
    </div>
</div>
@endsection
