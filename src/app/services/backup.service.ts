import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BackupService {

  private backupUrl = 'http://localhost/PROJET_ceREF/backend/backup.php'; // Chemin vers votre script PHP de sauvegarde

  constructor(private http: HttpClient) { }

  backupDatabase(): Observable<any> {
    return this.http.post(this.backupUrl, null);
  }
}
