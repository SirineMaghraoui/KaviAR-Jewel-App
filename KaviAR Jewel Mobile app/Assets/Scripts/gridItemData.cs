using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.SceneManagement;
public class gridItemData : MonoBehaviour {
    public string itemId;
    string directoryName1 = "/My_projects";
    string directoryName2 = "/Public_projects";
    userInfo UserInfo_data;
    public void item () {
        if (SceneManager.GetActiveScene ().name == "MyProjects") {
            data.selected_personal_project = itemId;
            UserInfo_data = saveSystem.loadUserInfo ();
            Project[] my_projects = UserInfo_data.my_projects;
            string type = "";
            string path = "";
            string fileName;
            foreach (Project p in my_projects) {
                if (p.id_project == itemId) {
                    fileName = Path.GetFileName (p.model_path);
                    type = p.type;
                    path = Application.persistentDataPath + directoryName1 + "/" + fileName;
                    break;
                }
            }
            if (File.Exists (path)) {
                if (type == "ring") {
                    SceneManager.LoadScene ("PreviewRing", LoadSceneMode.Single);
                } else if (type == "watch") {
                    SceneManager.LoadScene ("PreviewWatch", LoadSceneMode.Single);
                }
            } else {
                SceneManager.LoadScene ("DownloadAssetBundle", LoadSceneMode.Single);
            }
        } else if (SceneManager.GetActiveScene ().name == "PublicProjects") {
            data.selected_public_project = itemId;
            string path = "";
            UserInfo_data = saveSystem.loadUserInfo ();
            Project[] my_projects = UserInfo_data.public_projects;
            string type = "";
            string fileName = "";
            foreach (Project p in my_projects) {
                if (p.id_project == itemId) {
                    fileName = Path.GetFileName (p.model_path);
                    type = p.type;
                    path = Application.persistentDataPath + directoryName2 + "/" + fileName;
                    break;
                }
            }
            if (File.Exists (path)) {
                if (type == "ring") {
                    SceneManager.LoadScene ("PreviewRing", LoadSceneMode.Single);
                } else if (type == "watch") {
                    SceneManager.LoadScene ("PreviewWatch", LoadSceneMode.Single);
                }
            } else {
                SceneManager.LoadScene ("DownloadAssetBundle", LoadSceneMode.Single);
            }
        } else if (SceneManager.GetActiveScene ().name == "PublicUsers") {
            data.selected_public_user = itemId;
            SceneManager.LoadScene ("PublicProjects", LoadSceneMode.Single);
        }
    }
}