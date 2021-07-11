using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
public class downloadAB : MonoBehaviour {
    // Start is called before the first frame update

    string directoryName1 = "/My_projects";
    string directoryName2 = "/Public_projects";
    string downloadPath = "";
    string savePath = "";

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
    userInfo UserInfo_data;
    string type;
    void Start () {
        UserInfo_data = saveSystem.loadUserInfo ();
        if (data.selected_personal_project != "" && data.selected_public_project == "") {
            Project[] my_projects = UserInfo_data.my_projects;
            foreach (Project p in my_projects) {
                if (data.selected_personal_project == p.id_project) {
                    downloadPath = "http://jewel-app.kaviar.app/" + p.model_path;
                    string fileName = Path.GetFileName (p.model_path);
                    savePath = Application.persistentDataPath + directoryName1 + "/" + fileName;
                    type = p.type;
                    break;
                }
            }

        } else if (data.selected_personal_project == "" && data.selected_public_project != "") {
            Project[] public_projects = UserInfo_data.public_projects;
            foreach (Project p in public_projects) {
                if (data.selected_public_project == p.id_project) {
                    downloadPath = "http://jewel-app.kaviar.app/" + p.model_path;
                    string fileName = Path.GetFileName (p.model_path);
                    savePath = Application.persistentDataPath + directoryName2 + "/" + fileName;
                    type = p.type;
                    break;
                }
            }
        }
        StartCoroutine (loadDowlnoadFiles ());
    }

    IEnumerator loadDowlnoadFiles () {
        if (!File.Exists (savePath)) {
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

                UnityWebRequest www = UnityWebRequest.Get (downloadPath);
                var asynchoperation = www.SendWebRequest ();

                while (!www.isDone) {
                    if (Application.internetReachability == NetworkReachability.NotReachable) {
                        SceneManager.LoadScene ("DownloadDefaultProjects", LoadSceneMode.Single);
                    }
                    percentage.text = (asynchoperation.progress * 100).ToString ("f0") + " %";
                    yield return null;
                }
                File.WriteAllBytes (savePath, www.downloadHandler.data);
                
                if (File.Exists (savePath)) {
                    if (type == "ring") {
                        SceneManager.LoadScene ("PreviewRing", LoadSceneMode.Single);
                    } else if (type == "watch") {
                        SceneManager.LoadScene ("PreviewWatch", LoadSceneMode.Single);
                    }
                }
            }

        }
    }

}