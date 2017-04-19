import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Rx';
import { environment } from '../../environments/environment';

@Injectable()
export class UploadService {
    progress: any;
    progressObserver: any;
    environment:any = environment;

    constructor () {
        this.progress = Observable.create(observer => {
            this.progressObserver = observer
        }).share();
    }

    public makeFileRequest (params: string[], files: File[]): Observable<any> {
        return Observable.create(observer => {
            let i: number;
            let formData: FormData = new FormData(),
            xhr: XMLHttpRequest = new XMLHttpRequest();            

            for (i = 0; i < files.length; i++) {
                formData.append("uploads[]", files[i], files[i].name);
            }
            for (i = 0; i < params.length; i++) {
                formData.append("params["+i+"]", params[i]);
            }            

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        observer.next(JSON.parse(xhr.response));
                        observer.complete();
                    } else {
                        observer.error(xhr.response);
                    }
                }
            };

            xhr.upload.onprogress = (event) => {
                this.progress = Math.round(event.loaded / event.total * 100);
                //console.log(this.progress);
                //this.progressObserver.next(this.progress);
            };

            xhr.open('POST', environment.serverUrl + environment.urlFileUpload, true);
            xhr.send(formData);
        });
    }
}