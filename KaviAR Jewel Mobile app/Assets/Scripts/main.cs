using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class main : MonoBehaviour {
    public static main instance;
    public web web;
    public userInfo UserInfo;
    // Start is called before the first frame update
    void Start () {
        instance = this;
        web = GetComponent<web> ();
    }

}