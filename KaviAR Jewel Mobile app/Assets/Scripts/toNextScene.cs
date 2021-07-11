using System.Collections;
using System.Collections.Generic;
using OpenCVForUnityExample;
using UnityEngine;
using UnityEngine.SceneManagement;

public class toNextScene : MonoBehaviour {

    public string scenaname;
    public string url;
    public GameObject cam;
    public void toscene () {
        SceneManager.LoadScene (scenaname, LoadSceneMode.Single);
    }
    public void toscenestopwebcam () {
        if (SceneManager.GetActiveScene ().name == "TryOnRing") {
            cam.GetComponent<tryOnRing> ().webCamTexture.Stop ();
        } else if (SceneManager.GetActiveScene ().name == "TryOnWatch") {
            cam.GetComponent<tryOnWatch> ().webCamTexture.Stop ();
        }
        SceneManager.LoadScene (scenaname, LoadSceneMode.Single);
    }
    public void toscenestopwebcam2 () {
        if (SceneManager.GetActiveScene ().name == "TryOnRing") {
            cam.GetComponent<tryOnRing> ().webCamTexture.Stop ();
            if (data.selected_personal_project == "" && data.selected_public_project == "") {
                SceneManager.LoadScene (scenaname, LoadSceneMode.Single);
            } else {
                SceneManager.LoadScene ("PreviewRing", LoadSceneMode.Single);
            }
        } else if (SceneManager.GetActiveScene ().name == "TryOnWatch") {
            cam.GetComponent<tryOnWatch> ().webCamTexture.Stop ();
            if (data.selected_personal_project == "" && data.selected_public_project == "") {
                SceneManager.LoadScene (scenaname, LoadSceneMode.Single);
            } else {
                SceneManager.LoadScene ("PreviewWatch", LoadSceneMode.Single);
            }
        }
    }

    public void useURL () {
        Application.OpenURL (url);
    }
    public void urlData () {
        if (data.url != "")
            Application.OpenURL (data.url);
    }
}