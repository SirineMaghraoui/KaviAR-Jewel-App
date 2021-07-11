using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

public class loading : MonoBehaviour {
    public Text amount;
    // Start is called before the first frame update
    void Start () {
        StartCoroutine (LoadYourAsyncScene ());
    }

    IEnumerator LoadYourAsyncScene () {
        AsyncOperation asyncLoad = SceneManager.LoadSceneAsync ("CameraFeedProcess", LoadSceneMode.Single);
        while (!asyncLoad.isDone) {
            float prog = Mathf.Clamp01 (asyncLoad.progress / .9f);
            amount.text = (prog * 100).ToString ();
            yield return null;
        }
    }
}