using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class rorateRing : MonoBehaviour {
    public float rotSpeed = 280;

    void OnMouseDrag () {
        float rotX = Input.GetAxis ("Mouse X") * rotSpeed * Mathf.Deg2Rad * Time.deltaTime;
        float rotY = Input.GetAxis ("Mouse Y") * rotSpeed * Mathf.Deg2Rad * Time.deltaTime;
        transform.RotateAround (Vector3.up, -rotX);
        transform.RotateAround (Vector3.right, rotY);
    }
}