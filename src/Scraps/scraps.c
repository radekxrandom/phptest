#include <stdio.h>
#include <stdlib.h>
#include <php.h>
#include "php_calcout.h"


// register our function to the PHP API
// so that PHP knows, which functions are in this module
zend_function_entry calcout_php_functions[] = {
    PHP_FE(calcout_php, NULL)
    {NULL, NULL, NULL}
};


// some pieces of information about our module
zend_module_entry calcout_php_module_entry = {
    STANDARD_MODULE_HEADER,
    PHP_CALCOUT_EXTNAME,
    calcout_php_functions,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    PHP_CALCOUT_VERSION,
    STANDARD_MODULE_PROPERTIES
};

ZEND_GET_MODULE(calcout_php)


PHP_FUNCTION(calcout_php){

  zend_long lval;
  long i = 1;
  long el = 2;
  long highest = 0;

  if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC , "l", &lval) == FAILURE){
    return;
  }

  long arr[lval];
  arr[lval] = 0;
  arr[0] = 1;
  arr[1] = 1;

  while(arr[lval] == 0){
    long element = arr[i];
    long precedent = arr[i-1];
    arr[el] = element + precedent;
    el++;
    arr[el] = element;
    el++;
    i++;
  }

  for(long j = 0; j < lval; j++){
    if(highest < arr[j]){
      highest = arr[j];
    }
  }

  RETURN_LONG(highest);
}

long calculate(long *n,  long len){

  //int sequence[n] = {0};
  long i = 1;



  long el = 2;

  while(n[len] == 0){
    long element = n[i];
    long precedent = n[i-1];
    n[el] = element+precedent;
    el++;
    n[el] = element;
    el++;
     i++;
  }

 long highest = 0;

  for(long j = 0; j < len; j++){
    if(highest < n[j]){
      highest = n[j];
    }
  }

  return highest;
}

int main (){

   long n = 99999;
   long *arr;

  arr = malloc(n*sizeof(long));

  arr[n] = 0;
  arr[0] = 1;
  arr[1] = 1;
  long result = calculate(arr, n);

  printf("%ld", result);
  //free(arr);
  return  0;
}
