using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.SceneManagement;

public class mainManager : MonoBehaviour {
    string directoryName = "/Safe_Files";
    string defaultModelsFolder = "/Default_projects";
    string userModelsFrolder = "/My_projects";
    string publicModelsFrolder = "/Public_projects";
    void Start () {
        createSaveDirectory (directoryName, defaultModelsFolder, userModelsFrolder, publicModelsFrolder);
    }
    public void launch () {
        if (PlayerPrefs.GetString ("logged") == "true") {
            if (Application.internetReachability == NetworkReachability.NotReachable) {
                SceneManager.LoadScene ("ProjectChoice", LoadSceneMode.Single);
            } else {
                SceneManager.LoadScene ("CheckUpdates", LoadSceneMode.Single);
            }
        } else {
            SceneManager.LoadScene ("Login", LoadSceneMode.Single);
        }
    }

    void createSaveDirectory (string directoryPath, string defaultModels, string userModels, string publicModels) {
        DirectoryInfo dirInf = new DirectoryInfo (Application.persistentDataPath + directoryPath);
        if (!dirInf.Exists) {
            dirInf.Create ();
            Debug.Log (Application.persistentDataPath + directoryPath + "directory created ");
        }
        dirInf = new DirectoryInfo (Application.persistentDataPath + defaultModels);
        if (!dirInf.Exists) {
            dirInf.Create ();
            Debug.Log (Application.persistentDataPath + defaultModels + "directory created ");
        }
        dirInf = new DirectoryInfo (Application.persistentDataPath + userModels);
        if (!dirInf.Exists) {
            dirInf.Create ();
            Debug.Log (Application.persistentDataPath + userModels + "directory created ");
        }
        dirInf = new DirectoryInfo (Application.persistentDataPath + publicModels);
        if (!dirInf.Exists) {
            dirInf.Create ();
            Debug.Log (Application.persistentDataPath + userModels + "directory created ");
        }

    }
}