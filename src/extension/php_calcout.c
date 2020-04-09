#include <stdio.h>
#include <stdlib.h>
#include <php.h>
#include "php_calcout.h"
typedef unsigned long ulong;


ZEND_BEGIN_ARG_INFO_EX(arginfo_calcout_calc, 0, 0, 1)
ZEND_ARG_INFO(0, lval)
ZEND_END_ARG_INFO()


// register our function to the PHP API
// so that PHP knows, which functions are in this module
zend_function_entry calcout_functions[] = {
    PHP_FE(calcout_calc, arginfo_calcout_calc)
    {NULL, NULL, NULL}
};



// some pieces of information about our module
zend_module_entry calcout_module_entry = {
    STANDARD_MODULE_HEADER,
    PHP_CALCOUT_EXTNAME,
    calcout_functions,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    PHP_CALCOUT_VERSION,
    STANDARD_MODULE_PROPERTIES
};

ZEND_GET_MODULE(calcout)


 long max(long *seq, int len){
    long highest = 0;

    while(--len){
        if(highest < *(seq+len)) highest = *(seq+len);
    }

    return highest;
}

void calc_seq(long *seq, int len){
    int i = *(seq+1) = *seq = 1;

    while( (i<<1)+1 < len) {
        *(seq+(i<<1))         = *(seq+i)+*(seq+i-1);
        *(seq+(((i++)<<1)+1)) = *(seq+i-1);
    }

    if((len%2) != 0){
        *(seq+(i<<1)) = *(seq+i)+*(seq+i-1);
    }
}

long calc_max_in_sec(long *seq, int len){
    calc_seq(seq, len);
    return max(seq,len);
}


PHP_FUNCTION(calcout_calc){


  long lval;

      if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &lval) == FAILURE){
      return;
    }

    // heap allocation
    long *tab_heap = malloc(sizeof(long) * lval);
    long highest = calc_max_in_sec(tab, lval);
    free(tab_heap);

    RETURN_LONG(highest);
}
