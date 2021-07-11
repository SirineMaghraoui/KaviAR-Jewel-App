using System.Collections;
using System.Collections.Generic;
using OpenCVForUnityExample;
using UnityEngine;
using UnityEngine.SceneManagement;

public class loadingManager : MonoBehaviour {
    // Start is called before the first frame update

    public static IEnumerator beginLoading () {
        if (SceneManager.GetActiveScene ().name == "TryOnRing") {
            tryOnRing.show = true;
            yield return new WaitForSeconds (0.5f);
            tryOnRing.Capture ();
        } else if (SceneManager.GetActiveScene ().name == "TryOnWatch") {
            tryOnWatch.show = true;
            yield return new WaitForSeconds (0.5f);
            tryOnWatch.Capture ();
        }
    }
}