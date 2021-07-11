using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
public class previewRingBack : MonoBehaviour {
    public void check () {
        if (data.selected_personal_project != "" && data.selected_public_project == "") {
            SceneManager.LoadScene ("MyProjects", LoadSceneMode.Single);
        } else if (data.selected_personal_project == "" && data.selected_public_project != "") {
            SceneManager.LoadScene ("PublicProjects", LoadSceneMode.Single);
        }
    }
}