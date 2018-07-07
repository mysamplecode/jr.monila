<?php

RocketPack\Install::package('rocketsled.workingsoftware.com.au:/usr/local/share/gitroot/Config', array(0, 0, 0));

RocketPack\Dependencies::register(function() {
    RocketPack\Dependency::forPackage('rocketsled.workingsoftware.com.au:/usr/local/share/gitroot/Config')
            ->add('rocketsled.workingsoftware.com.au:/usr/local/share/gitroot/EasyErpSystemHtml', array(0, 0, 0))
            ->add('https://github.com/iaindooley/PluSQL', array(0, 2, 3))
            ->add('https://github.com/iaindooley/Args', array(0, 2, 1))
            ->add('https://github.com/iaindooley/Murphy', array(0, 2, 2))
            ->verify();
});
