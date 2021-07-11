using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
public class populate : MonoBehaviour {
    public GameObject no_project;
    public GameObject add_project;
    public GameObject no_users;
    public GameObject prefabGridElement;
    userInfo userInfo_data;
    Project[] myprojects;
    Project[] publicprojects;
    userInfo[] publicusers;
    string directoryName = "/My_projects";
    string directoryName2 = "/Public_projects";

    string fileName;
    string path;

    // Start is called before the first frame update
    void Start () {
        if (SceneManager.GetActiveScene ().name == "MyProjects") {
            data.selected_personal_project = "";
        } else if (SceneManager.GetActiveScene ().name == "PublicProjects") {
            data.selected_public_project = "";
        } else if (SceneManager.GetActiveScene ().name == "PublicUsers") {
            data.selected_public_user = "";
        }
        userInfo_data = saveSystem.loadUserInfo ();
        myprojects = userInfo_data.my_projects;
        publicprojects = userInfo_data.public_projects;
        publicusers = userInfo_data.public_users;
        populateItems ();
    }

    void populateItems () {
        GameObject newobj;
        if (SceneManager.GetActiveScene ().name == "MyProjects") {
            if (myprojects.Length == 0) {
                no_project.SetActive (true);
                add_project.SetActive (true);
            } else {
                foreach (Project p in myprojects) {
                    newobj = (GameObject) Instantiate (prefabGridElement, transform);
                    fileName = Path.GetFileName (p.thumbnail_path);
                    path = Application.persistentDataPath + directoryName + "/" + fileName;
                    byte[] bytes = System.IO.File.ReadAllBytes (path);
                    Texture2D texture = new Texture2D (1, 1);
                    texture.LoadImage (bytes);
                    Sprite sprite = Sprite.Create (texture, new Rect (0, 0, texture.width, texture.height), new Vector2 (0.5f, 0.5f));
                    GameObject project_name = newobj.transform.Find ("name").gameObject;
                    project_name.GetComponent<Text> ().text = p.project_name;
                    GameObject mask = newobj.transform.Find ("mask").gameObject;
                    GameObject project_thumbnail = mask.transform.Find ("image").gameObject;
                    project_thumbnail.GetComponent<Image> ().sprite = sprite;
                    newobj.GetComponent<gridItemData> ().itemId = p.id_project;
                }
            }

        } else if (SceneManager.GetActiveScene ().name == "PublicProjects") {
            bool ok = false;
            foreach (Project p in publicprojects) {
                if (p.id_user == data.selected_public_user) {
                    ok = true;
                    break;
                }
            }
            if (!ok) {
                no_project.SetActive (true);
            } else {
                foreach (Project p in publicprojects) {
                    if (p.id_user == data.selected_public_user) {
                        newobj = (GameObject) Instantiate (prefabGridElement, transform);
                        fileName = Path.GetFileName (p.thumbnail_path);
                        path = Application.persistentDataPath + directoryName2 + "/" + fileName;
                        byte[] bytes = System.IO.File.ReadAllBytes (path);
                        Texture2D texture = new Texture2D (1, 1);
                        texture.LoadImage (bytes);
                        Sprite sprite = Sprite.Create (texture, new Rect (0, 0, texture.width, texture.height), new Vector2 (0.5f, 0.5f));
                        GameObject project_name = newobj.transform.Find ("name").gameObject;
                        project_name.GetComponent<Text> ().text = p.project_name;
                        GameObject mask = newobj.transform.Find ("mask").gameObject;
                        GameObject project_thumbnail = mask.transform.Find ("image").gameObject;
                        project_thumbnail.GetComponent<Image> ().sprite = sprite;
                        newobj.GetComponent<gridItemData> ().itemId = p.id_project;
                    }
                }
            }

        } else if (SceneManager.GetActiveScene ().name == "PublicUsers") {
            if (publicusers.Length == 0) {
                no_users.SetActive (true);
            } else {
                foreach (userInfo p in publicusers) {
                    newobj = (GameObject) Instantiate (prefabGridElement, transform);
                    GameObject project_name = newobj.transform.Find ("name").gameObject;
                    project_name.GetComponent<Text> ().text = p.username;
                    newobj.GetComponent<gridItemData> ().itemId = p.id_user;
                    if (p.picture_path != "") {
                        fileName = Path.GetFileName (p.picture_path);
                        path = Application.persistentDataPath + directoryName2 + "/" + fileName;
                        byte[] bytes = System.IO.File.ReadAllBytes (path);
                        Texture2D texture = new Texture2D (1, 1);
                        texture.LoadImage (bytes);
                        Sprite sprite = Sprite.Create (texture, new Rect (0, 0, texture.width, texture.height), new Vector2 (0.5f, 0.5f));
                        GameObject mask = newobj.transform.Find ("mask").gameObject;
                        GameObject project_thumbnail = mask.transform.Find ("image").gameObject;
                        project_thumbnail.GetComponent<Image> ().sprite = sprite;
                    }
                }
            }
        }
    }
}