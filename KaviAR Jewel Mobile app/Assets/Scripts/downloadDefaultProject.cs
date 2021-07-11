using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
public class downloadDefaultProject : MonoBehaviour {
    // Start is called before the first frame update
    string defaul_rings_AB_path;
    string defaul_watches_AB_path;

    string defaultModelsFolder = "/Default_projects";
    string serverDirectory = "/defaultModels";
    string[] filesToDownload;
    string[] filesToDownload_paths;
    public GameObject loadingAnimation;
    public Text waittext;
    public Text errortext;
    public Text percentage;
    public Text filestext;
    public Text whoops;
    float progress_p;
    float progress_m;
    float progress = 0;
    float last_progress = 0;
    public GameObject cloud;
    public GameObject reload_button;
    int files = 0;
    int filesDownloading = 0;
    void Start () {
        defaul_rings_AB_path = "https://jewel-app.kaviar.app/" + serverDirectory + "/ring";
        defaul_watches_AB_path = "https://jewel-app.kaviar.app/" + serverDirectory + "/watch";

        filesToDownload = new string[2];
        filesToDownload_paths = new string[2];

        filesToDownload[0] = Application.persistentDataPath + defaultModelsFolder + "/ring";
        filesToDownload[1] = Application.persistentDataPath + defaultModelsFolder + "/watch";

        filesToDownload_paths[0] = defaul_rings_AB_path;
        filesToDownload_paths[1] = defaul_watches_AB_path;

        for (int j = 0; j < filesToDownload.Length; j++) {
            if (!File.Exists (filesToDownload[j])) {
                files++;
            }
        }
        StartCoroutine (loadDowlnoadFiles ());
    }

    IEnumerator loadDowlnoadFiles () {
        if (!File.Exists (filesToDownload[0]) || !File.Exists (filesToDownload[1])) {
            if (Application.internetReachability == NetworkReachability.NotReachable) {
                errortext.gameObject.SetActive (true);
                whoops.gameObject.SetActive (true);
                cloud.SetActive (true);
                reload_button.SetActive (true);
            } else {
                waittext.gameObject.SetActive (true);
                loadingAnimation.SetActive (true);
                percentage.gameObject.SetActive (true);
                filestext.gameObject.SetActive (true);

                for (int i = 0; i < filesToDownload.Length; i++) {
                    if (!File.Exists (filesToDownload[i])) {
                        filesDownloading++;
                        UnityWebRequest www = UnityWebRequest.Get (filesToDownload_paths[i]);
                        var asynchoperation = www.SendWebRequest ();

                        while (!www.isDone) {
                            if (Application.internetReachability == NetworkReachability.NotReachable) {
                                SceneManager.LoadScene ("DownloadDefaultProjects", LoadSceneMode.Single);
                            }
                            percentage.text = (asynchoperation.progress * 100).ToString ("f0") + " %";
                            filestext.text = "(" + filesDownloading.ToString () + "/" + files.ToString () + ")";
                            yield return null;
                        }
                        File.WriteAllBytes (filesToDownload[i], www.downloadHandler.data);
                    }
                }
                if (File.Exists (filesToDownload[0]) && File.Exists (filesToDownload[1])) {
                    SceneManager.LoadScene ("SelectChoice", LoadSceneMode.Single);
                }
            }

        }
    }

}