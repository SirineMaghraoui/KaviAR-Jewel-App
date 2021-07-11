using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
public class SetLangGrid : MonoBehaviour {
    public Text title;
    string title_my_projects_fr = "Mes projets";
    string title_my_projects_eng = "My projects";
    string title_public_projects_fr = "Projets publics";
    string title_public_projects_eng = "Public projects";
    string title_public_users_fr = "Utilisateurs publics";
    string title_public_users_eng = "Public users";
    // Start is called before the first frame update
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            if (SceneManager.GetActiveScene ().name == "MyProjects") {
                title.text = title_my_projects_fr;
            } else if (SceneManager.GetActiveScene ().name == "PublicUsers") {
                title.text = title_public_users_fr;
            } else if (SceneManager.GetActiveScene ().name == "PublicProjects") {
                title.text = title_public_projects_fr;
            }
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            if (SceneManager.GetActiveScene ().name == "MyProjects") {
                title.text = title_my_projects_eng;
            } else if (SceneManager.GetActiveScene ().name == "PublicUsers") {
                title.text = title_public_users_eng;
            } else if (SceneManager.GetActiveScene ().name == "PublicProjects") {
                title.text = title_public_projects_eng;
            }
        }
    }

}