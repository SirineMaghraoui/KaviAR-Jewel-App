using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class SetLangProfile : MonoBehaviour {
    public Text logout;
    public Text my_projects;
    public Text public_users;
    public Text default_projects;
    string logout_fr = "Se\ndéconnecter";
    string my_projects_fr = "Mes\nprojets";
    string public_users_fr = "Utilisateurs\npublics";
    string default_projects_fr = "Projets\npar défaut";
    string logout_eng = "Logout";
    string my_projects_eng = "My\nprojects";
    string public_users_eng = "Public\nusers";
    string default_projects_eng = "Default\nprojects";
    // Start is called before the first frame update
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            logout.text = logout_fr;
            my_projects.text = my_projects_fr;
            public_users.text = public_users_fr;
            default_projects.text = default_projects_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            logout.text = logout_eng;
            my_projects.text = my_projects_eng;
            public_users.text = public_users_eng;
            default_projects.text = default_projects_eng;
        }
    }

}