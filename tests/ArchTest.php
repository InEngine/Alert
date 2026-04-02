<?php

/**
 * ArchTest
 * Architecture rules: forbid debug helpers in production code paths covered by the arch plugin.
 */
arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
