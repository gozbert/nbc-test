package com.company;
import java.util.Arrays;
import java.util.Scanner;

public class Main {
    private int max(int[] array) {
        int max = 0;

        for(int i=0; i<array.length; i++ ) {
            if(array[i]>max) {
                max = array[i];
            }
        }
        return max;
    }

    private int min(int[] array) {
        int min = array[0];

        for(int i = 0; i<array.length; i++ ) {
            if(array[i]<min) {
                min = array[i];
            }
        }
        return min;
    }

    private boolean negativeCheck(int[] array)
    {
        return array != null && Arrays.stream(array).anyMatch(i -> i < 0);
    }

    private boolean sizeCheck(int[] array){
        return Arrays.stream(array).count() > 5;
    }

    public int process(int[] array) {
        if(negativeCheck(array)){
            return 0;
        }
        if(sizeCheck(array)){
            return -1;
        }

        int max = max(array);
        int min = min(array);

        return max + min;
    }

    public static void main(String args[]) {
        Scanner sc = new Scanner(System.in);
        System.out.println("Enter items size");
        int size = sc.nextInt();
        int[] arr = new int[size];
        System.out.println("Enter the elements :-");

        for(int i=0; i<size; i++) {
            arr[i] = sc.nextInt();
        }

        Main m = new Main();
        int result = m.process(arr);

        if(result == -1){
            System.out.println("Array size should be less than 5");
        }else {
            System.out.println("Result:: " + m.process(arr));
        }
    }
}