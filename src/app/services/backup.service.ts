import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse } from '@angular/common/http';
import { Observable } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class BackupService {

  private backupUrl = 'http://localhost/PROJET_ceREF/backend/backup.php';

  constructor(private http: HttpClient) { }

  exportDatabase(): Observable<any> {
    return this.http.post<any>(this.backupUrl, null);
  }
}
