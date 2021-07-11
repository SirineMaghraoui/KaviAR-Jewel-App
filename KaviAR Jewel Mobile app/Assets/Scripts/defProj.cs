using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.SceneManagement;

public class defProj : MonoBehaviour {
    string directoryName = "/Default_projects";
    public void check () {
        if (File.Exists (Application.persistentDataPath + directoryName + "/ring") && File.Exists (Application.persistentDataPath + directoryName + "/watch")) {
            SceneManager.LoadScene ("SelectChoice", LoadSceneMode.Single);
        } else {
            SceneManager.LoadScene ("DownloadDefaultProjects", LoadSceneMode.Single);
        }

    }
}