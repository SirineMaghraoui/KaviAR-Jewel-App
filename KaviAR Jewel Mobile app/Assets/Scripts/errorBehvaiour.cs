using System.Collections;
using System.Collections.Generic;
using OpenCVForUnityExample;
using UnityEngine;
using UnityEngine.SceneManagement;
public class errorBehvaiour : MonoBehaviour {
    Animator anim;
    public GameObject manager;
    // Start is called before the first frame update
    void Start () {
        anim = this.GetComponent<Animator> ();
    }

    // Update is called once per frame
    void Update () {
        if (SceneManager.GetActiveScene ().name == "TryOnRing") {
            if (anim.GetCurrentAnimatorStateInfo (0).IsName ("end_error")) {
                tryOnRing.error = false;
                tryOnRing.startProcess = true;
                manager.GetComponent<tryOnRing> ().reset ();
            }
        } else if (SceneManager.GetActiveScene ().name == "TryOnWatch") {
            if (anim.GetCurrentAnimatorStateInfo (0).IsName ("end_error")) {
                tryOnWatch.error = false;
                tryOnWatch.startProcess = true;
                manager.GetComponent<tryOnWatch> ().reset ();
            }
        }

    }
}