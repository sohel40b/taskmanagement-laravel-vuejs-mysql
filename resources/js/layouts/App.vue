<template>
    <nav class="navbar navbar-expand-lg bg-body-secondary">
        <div class="container-fluid">
            <router-link to='/' class="navbar-brand fw-bold ">Task Management System</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;"></ul>
                <div class="d-flex">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <router-link to='/login' class="nav-link">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to='/register' class="nav-link">Register</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <router-view></router-view>
</template>
