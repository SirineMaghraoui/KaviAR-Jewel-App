using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

public class CheckProjectUpdates : MonoBehaviour {
    string directoryName1 = "/My_projects";
    string directoryName2 = "/Public_projects";
    string directoryName = "/Safe_Files";

    userInfo UserInfo_data = new userInfo ();
    Project[] myprojects;
    Project[] publicprojects;
    userInfo[] publicusers;

    public Text errortext;
    public Text whoops;
    public GameObject cloud;
    public GameObject reload_button;
    public GameObject offline_button;
    public GameObject loadingAnimation;
    public Text waittext;
    string username;
    string password;

    IEnumerator Start () {

        if (Application.internetReachability == NetworkReachability.NotReachable) {
            errortext.gameObject.SetActive (true);
            whoops.gameObject.SetActive (true);
            cloud.SetActive (true);
            reload_button.SetActive (true);
            offline_button.SetActive (true);
        } else {
            waittext.gameObject.SetActive (true);
            loadingAnimation.SetActive (true);

            username = PlayerPrefs.GetString ("username");
            password = PlayerPrefs.GetString ("password");
            WWWForm form = new WWWForm ();
            form.AddField ("username", username);
            form.AddField ("password", password);
            using (UnityWebRequest www = UnityWebRequest.Post ("https://jewel-app.kaviar.app/api/login", form)) {
                yield return www.SendWebRequest ();
                if (www.isNetworkError || www.isHttpError) {
                    if (Application.internetReachability == NetworkReachability.NotReachable) {
                        errortext.gameObject.SetActive (true);
                        whoops.gameObject.SetActive (true);
                        cloud.SetActive (true);
                        reload_button.SetActive (true);
                        offline_button.SetActive (true);
                    } else {
                        Debug.Log (www.error);
                    }
                } else {
                    string JsonArray = www.downloadHandler.text;
                    Debug.Log (JsonArray);
                    userInfo UserInfo = new userInfo ();
                    UserInfo = JsonUtility.FromJson<userInfo> (JsonArray);
                    if (UserInfo.status == "error") {
                        Debug.Log (UserInfo.message);
                    } else {
                        saveSystem.saveUserInfo (UserInfo);
                        UserInfo_data = saveSystem.loadUserInfo ();
                        myprojects = UserInfo_data.my_projects;
                        publicprojects = UserInfo_data.public_projects;
                        publicusers = UserInfo_data.public_users;

                        foreach (Project p in myprojects) {
                            string fileName = Path.GetFileName (p.thumbnail_path);
                            string path = Application.persistentDataPath + directoryName1 + "/" + fileName;
                            if (fileName != "") {
                                string thumbnail_url = "https://jewel-app.kaviar.app/" + p.thumbnail_path;

                                if (File.Exists (Application.persistentDataPath + directoryName1 + "/" + p.id_project + "_thumbnail.png")) {
                                    File.Delete (Application.persistentDataPath + directoryName1 + "/" + p.id_project + "_thumbnail.png");
                                }
                                if (File.Exists (Application.persistentDataPath + directoryName1 + "/" + p.id_project + "_thumbnail.jpg")) {
                                    File.Delete (Application.persistentDataPath + directoryName1 + "/" + p.id_project + "_thumbnail.jpg");
                                }
                                if (File.Exists (Application.persistentDataPath + directoryName1 + "/" + p.id_project + "_thumbnail.jpeg")) {
                                    File.Delete (Application.persistentDataPath + directoryName1 + "/" + p.id_project + "_thumbnail.jpeg");
                                }

                                UnityWebRequest www1 = UnityWebRequest.Get (thumbnail_url);
                                yield return www1.Send ();
                                if (www1.isNetworkError || www1.isHttpError) {
                                    if (Application.internetReachability == NetworkReachability.NotReachable) {
                                        SceneManager.LoadScene ("CheckUpdates", LoadSceneMode.Single);
                                    } else {
                                        Debug.Log (www1.error);
                                    }
                                } else {
                                    File.WriteAllBytes (path, www1.downloadHandler.data);
                                }
                            }
                        }

                        foreach (Project p in publicprojects) {
                            string fileName = Path.GetFileName (p.thumbnail_path);
                            string path = Application.persistentDataPath + directoryName2 + "/" + fileName;
                            if (fileName != "") {
                                string thumbnail_url = "https://jewel-app.kaviar.app/" + p.thumbnail_path;

                                if (File.Exists (Application.persistentDataPath + directoryName2 + "/" + p.id_project + "_thumbnail.png")) {
                                    File.Delete (Application.persistentDataPath + directoryName2 + "/" + p.id_project + "_thumbnail.png");
                                }
                                if (File.Exists (Application.persistentDataPath + directoryName2 + "/" + p.id_project + "_thumbnail.jpg")) {
                                    File.Delete (Application.persistentDataPath + directoryName2 + "/" + p.id_project + "_thumbnail.jpg");
                                }
                                if (File.Exists (Application.persistentDataPath + directoryName2 + "/" + p.id_project + "_thumbnail.jpeg")) {
                                    File.Delete (Application.persistentDataPath + directoryName2 + "/" + p.id_project + "_thumbnail.jpeg");
                                }

                                UnityWebRequest www2 = UnityWebRequest.Get (thumbnail_url);
                                yield return www2.Send ();
                                if (www2.isNetworkError || www2.isHttpError) {
                                    if (Application.internetReachability == NetworkReachability.NotReachable) {
                                        SceneManager.LoadScene ("CheckUpdates", LoadSceneMode.Single);
                                    } else {
                                        Debug.Log (www2.error);
                                    }
                                } else {
                                    File.WriteAllBytes (path, www2.downloadHandler.data);
                                }
                            }
                        }

                        foreach (userInfo u in publicusers) {

                            string fileName = Path.GetFileName (u.picture_path);
                            string path = Application.persistentDataPath + directoryName2 + "/" + fileName;
                            if (fileName != "") {
                                string picture_url = "https://jewel-app.kaviar.app/" + u.picture_path;

                                if (File.Exists (Application.persistentDataPath + directoryName2 + "/" + u.id_user + "_picture.png")) {
                                    File.Delete (Application.persistentDataPath + directoryName2 + "/" + u.id_user + "_picture.png");
                                }
                                if (File.Exists (Application.persistentDataPath + directoryName2 + "/" + u.id_user + "_picture.jpg")) {
                                    File.Delete (Application.persistentDataPath + directoryName2 + "/" + u.id_user + "_picture.jpg");
                                }
                                if (File.Exists (Application.persistentDataPath + directoryName2 + "/" + u.id_user + "_picture.jpeg")) {
                                    File.Delete (Application.persistentDataPath + directoryName2 + "/" + u.id_user + "_picture.jpeg");
                                }

                                UnityWebRequest www3 = UnityWebRequest.Get (picture_url);
                                Debug.Log (picture_url);
                                yield return www3.Send ();
                                if (www3.isNetworkError || www3.isHttpError) {
                                    if (Application.internetReachability == NetworkReachability.NotReachable) {
                                        SceneManager.LoadScene ("CheckUpdates", LoadSceneMode.Single);
                                    } else {
                                        Debug.Log (www3.error);
                                    }
                                } else {
                                    File.WriteAllBytes (path, www3.downloadHandler.data);
                                }
                            }
                        }

                        SceneManager.LoadScene ("ProjectChoice", LoadSceneMode.Single);
                    }
                }
            }
        }

    }

}