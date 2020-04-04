PHP_ARG_ENABLE(php_calcout, Whether to enable the CalculateOutput extension, [ --enable-calcout-php Enable calcoutphp])

if test "$PHP_CALCOUT" != "no"; then
    PHP_NEW_EXTENSION(php_calcout, php_calcout.c, $ext_shared)
fi
