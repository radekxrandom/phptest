#include <stdio.h>
#include <stdlib.h>

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
