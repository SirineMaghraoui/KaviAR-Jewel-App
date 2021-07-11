using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Runtime.Serialization.Formatters.Binary;
using UnityEngine;

public class saveSystem : MonoBehaviour {
    static string directoryName = "/Safe_Files";
    public static void saveUserInfo (userInfo userInfo_data) {
        BinaryFormatter formatter = new BinaryFormatter ();
        string path = Application.persistentDataPath + directoryName + "/userInfo.dat";
        FileStream stream = new FileStream (path, FileMode.Create);
        formatter.Serialize (stream, userInfo_data);
        stream.Close ();
    }

    public static userInfo loadUserInfo () {
        string path = Application.persistentDataPath + directoryName + "/userInfo.dat";
        if (File.Exists (path)) {
            BinaryFormatter formatter = new BinaryFormatter ();
            FileStream stream = new FileStream (path, FileMode.Open);
            userInfo userInfo_data = formatter.Deserialize (stream) as userInfo;
            stream.Close ();
            return userInfo_data;
        } else {
            Debug.Log ("save file not found");
            return null;
        }
    }

}