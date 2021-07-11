using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;

public class myProjectsManager : MonoBehaviour {
    // Start is called before the first frame update
    string directoryName = "/My_projects";

    userInfo UserInfo_data = new userInfo ();
    Project[] myprojects;
    IEnumerator Start () {
        UserInfo_data = saveSystem.loadUserInfo ();
        myprojects = UserInfo_data.my_projects;
        foreach (Project p in myprojects) {
            string fileName = Path.GetFileName (p.thumbnail_path);
            string path = Application.persistentDataPath + directoryName + "/" + fileName;
            if (!File.Exists (path)) {
                string thumbnail_url = "https://jewel-app.kaviar.app/" + p.thumbnail_path;
                UnityWebRequest www = UnityWebRequest.Get (thumbnail_url);
                yield return www.Send ();
                if (www.isNetworkError || www.isHttpError) {
                    Debug.Log (www.error);
                } else {
                    File.WriteAllBytes (path, www.downloadHandler.data);
                }
            }
        }

    }
}