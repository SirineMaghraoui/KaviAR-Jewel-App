using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class userInfo {
    public string status;
    public string message;
    public string id_user;
    public string username;
    public string picture_path;
    public Project[] my_projects;
    public userInfo[] public_users;
    public Project[] public_projects;
}