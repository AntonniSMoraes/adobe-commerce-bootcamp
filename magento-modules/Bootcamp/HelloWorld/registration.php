<?php
    //app/code/Bootcamp/HelloWorld/registration.php

    use Magento\Framework\Component\ComponentRegistrar;
    ComponentRegistrar::register(
        ComponentRegistrar::MODULE,
        'Bootcamp_HelloWorld',
        __DIR__
    );