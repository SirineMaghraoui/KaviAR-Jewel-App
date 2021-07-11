using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.SceneManagement;
public class web : MonoBehaviour {

    public Login login;

    static string directoryName = "/Safe_Files";
    string prototextName = "/pose_deploy.prototxt";
    string modeltName = "/pose_iter_102000.caffemodel";

    public IEnumerator Login (string username, string password) {
        WWWForm form = new WWWForm ();
        form.AddField ("username", username);
        form.AddField ("password", password);

        using (UnityWebRequest www = UnityWebRequest.Post ("https://jewel-app.kaviar.app/api/login", form)) {
            yield return www.SendWebRequest ();

            if (www.isNetworkError || www.isHttpError) {
                if (Application.internetReachability == NetworkReachability.NotReachable) {
                    if (username == "" && password == "") {
                        if (PlayerPrefs.GetString ("language") == "eng") {
                            login.error_msg.text = "Username and password required";
                        } else if (PlayerPrefs.GetString ("language") == "fr") {
                            login.error_msg.text = "Username et password requis";
                        }
                    } else if (username != "" && password == "") {
                        if (PlayerPrefs.GetString ("language") == "eng") {
                            login.error_msg.text = "Password required";
                        } else if (PlayerPrefs.GetString ("language") == "fr") {
                            login.error_msg.text = "Password requis";
                        }
                    } else if (username == "" && password != "") {
                        if (PlayerPrefs.GetString ("language") == "eng") {
                            login.error_msg.text = "Username required";
                        } else if (PlayerPrefs.GetString ("language") == "fr") {
                            login.error_msg.text = "Username requis";
                        }
                    } else {
                        if (PlayerPrefs.GetString ("language") == "eng") {
                            login.error_msg.text = "Please check your internet connection";
                        } else if (PlayerPrefs.GetString ("language") == "fr") {
                            login.error_msg.text = "Vérifiez votre connexion internet";
                        }
                    }
                } else {
                    login.error_msg.text = www.error;
                }
            } else {
                if (username == "" && password == "") {
                    if (PlayerPrefs.GetString ("language") == "eng") {
                        login.error_msg.text = "Username and password required";
                    } else if (PlayerPrefs.GetString ("language") == "fr") {
                        login.error_msg.text = "Username et password requis";
                    }
                } else if (username != "" && password == "") {
                    if (PlayerPrefs.GetString ("language") == "eng") {
                        login.error_msg.text = "Password required";
                    } else if (PlayerPrefs.GetString ("language") == "fr") {
                        login.error_msg.text = "Password requis";
                    }
                } else if (username == "" && password != "") {
                    if (PlayerPrefs.GetString ("language") == "eng") {
                        login.error_msg.text = "Username required";
                    } else if (PlayerPrefs.GetString ("language") == "fr") {
                        login.error_msg.text = "Username requis";
                    }
                } else {
                    string JsonArray = www.downloadHandler.text;
                    Debug.Log (JsonArray);
                    userInfo UserInfo = new userInfo ();
                    UserInfo = JsonUtility.FromJson<userInfo> (JsonArray);
                    if (UserInfo.status == "error") {
                        if (UserInfo.message == "Wrong Username or Password") {
                            if (PlayerPrefs.GetString ("language") == "eng") {
                                login.error_msg.text = UserInfo.message;
                            } else if (PlayerPrefs.GetString ("language") == "fr") {
                                login.error_msg.text = "Username ou Password incorrect";
                            }
                            login.username.text = "";
                            login.password.text = "";
                        } else {
                            login.error_msg.text = UserInfo.message;
                        }
                    } else {
                        PlayerPrefs.SetString ("username", username);
                        PlayerPrefs.SetString ("password", password);
                        login.error_msg.text = "";
                        saveSystem.saveUserInfo (UserInfo);
                        userInfo UserInfo_data = saveSystem.loadUserInfo ();
                        string picture_url = "https://jewel-app.kaviar.app/" + UserInfo_data.picture_path;
                        string fileName = Path.GetFileName (picture_url);

                        if (fileName != "") {
                            if (File.Exists (Application.persistentDataPath + directoryName + "/" + UserInfo_data.id_user + "_picture.png")) {
                                File.Delete (Application.persistentDataPath + directoryName + "/" + UserInfo_data.id_user + "_picture.png");
                            }
                            if (File.Exists (Application.persistentDataPath + directoryName + "/" + UserInfo_data.id_user + "_picture.jpg")) {
                                File.Delete (Application.persistentDataPath + directoryName + "/" + UserInfo_data.id_user + "_picture.jpg");
                            }
                            if (File.Exists (Application.persistentDataPath + directoryName + "/" + UserInfo_data.id_user + "_picture.jpeg")) {
                                File.Delete (Application.persistentDataPath + directoryName + "/" + UserInfo_data.id_user + "_picture.jpeg");
                            }

                            UnityWebRequest www1 = UnityWebRequest.Get (picture_url);
                            yield return www1.Send ();
                            if (www1.isNetworkError || www1.isHttpError) {
                                Debug.Log (www1.error);
                            } else {
                                string savePath = Application.persistentDataPath + directoryName + "/" + fileName;
                                File.WriteAllBytes (savePath, www1.downloadHandler.data);
                            }
                        }
                        if (File.Exists (Application.persistentDataPath + directoryName + "/" + prototextName) && File.Exists (Application.persistentDataPath + directoryName + "/" + modeltName)) {
                            SceneManager.LoadScene ("CheckUpdates", LoadSceneMode.Single);
                        } else {
                            SceneManager.LoadScene ("CheckFiles", LoadSceneMode.Single);
                        }
                    }
                }
            }
        }
    }

    public void Logout () {
        PlayerPrefs.SetString ("logged", "false");
        PlayerPrefs.SetString ("username", "");
        PlayerPrefs.SetString ("password", "");
        SceneManager.LoadScene ("Login", LoadSceneMode.Single);
    }

}