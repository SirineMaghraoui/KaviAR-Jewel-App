using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
#if PLATFORM_ANDROID
using UnityEngine.Android;
#endif
#if UNITY_IOS
using UnityEngine.iOS;
#endif
using UnityEngine.Networking;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
public class loadDownloadAssets : MonoBehaviour {
    // Start is called before the first frame update
    string serverDirectory = "/DNN";

    string directoryName = "/Safe_Files";

    string prototextName = "/pose_deploy.prototxt";
    string modeltName = "/pose_iter_102000.caffemodel";
    string prototext_path;
    string model_path;
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
        //var contains full path from server: https+site+path_file+file_extention
        prototext_path = "https://jewel-app.kaviar.app/" + serverDirectory + prototextName;
        model_path = "https://jewel-app.kaviar.app/" + serverDirectory + modeltName;

        filesToDownload = new string[2];
        filesToDownload_paths = new string[2];

        //prepare full path of where to download the file on the device in variable (look for persistendatapath)
        filesToDownload[0] = Application.persistentDataPath + directoryName + modeltName;
        filesToDownload[1] = Application.persistentDataPath + directoryName + prototextName;

        filesToDownload_paths[0] = model_path;
        filesToDownload_paths[1] = prototext_path;

//never mind this, dont read it
#if PLATFORM_ANDROID
        if (Application.platform == RuntimePlatform.Android) {
            if (!Permission.HasUserAuthorizedPermission (Permission.Camera)) {
                Permission.RequestUserPermission (Permission.Camera);
            }
        }
#endif
#if UNITY_IOS
        if (Application.platform == RuntimePlatform.IPhonePlayer) {
            if (!Application.HasUserAuthorization (UserAuthorization.WebCam)) {
                Application.RequestUserAuthorization (UserAuthorization.WebCam);
            }
        }
#endif
//dont read this too
        for (int j = 0; j < filesToDownload.Length; j++) {
            if (!File.Exists (filesToDownload[j])) {
                files++;
            }
        }
        StartCoroutine (loadDowlnoadFiles ());
    }

    IEnumerator loadDowlnoadFiles () {
        //check if file exists on the phone, if it doesn exists it will download from server
        if (!File.Exists (filesToDownload[0]) || !File.Exists (filesToDownload[1])) {
            //check internet cnx
            if (Application.internetReachability == NetworkReachability.NotReachable) {
                errortext.gameObject.SetActive (true);
                whoops.gameObject.SetActive (true);
                cloud.SetActive (true);
                reload_button.SetActive (true);
            } else {
                //if internet ok
                waittext.gameObject.SetActive (true);
                loadingAnimation.SetActive (true);
                percentage.gameObject.SetActive (true);
                filestext.gameObject.SetActive (true);


                    //start download
                for (int i = 0; i < filesToDownload.Length; i++) {
                    if (!File.Exists (filesToDownload[i])) {
                        filesDownloading++;
                        UnityWebRequest www = UnityWebRequest.Get (filesToDownload_paths[i]);
                        var asynchoperation = www.SendWebRequest ();

                        while (!www.isDone) {
                            if (Application.internetReachability == NetworkReachability.NotReachable) {
                                //if internet is cut then reload scene
                                SceneManager.LoadScene ("CheckFiles", LoadSceneMode.Single);
                            }
                            //im showing the percentange of download here
                            percentage.text = (asynchoperation.progress * 100).ToString ("f0") + " %";
                            filestext.text = "(" + filesDownloading.ToString () + "/" + files.ToString () + ")";
                            yield return null;
                        }
                        //writing binaries on mobile
                        File.WriteAllBytes (filesToDownload[i], www.downloadHandler.data);
                    }
                }
                //if downlaod is done then go to next scene
                if (File.Exists (filesToDownload[0]) && File.Exists (filesToDownload[1])) {
                    SceneManager.LoadScene ("CheckUpdates", LoadSceneMode.Single);
                }
            }
        }
    }
}