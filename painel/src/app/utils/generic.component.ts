import { environment } from '../../environments/environment';
import { FormGroup, FormBuilder } from '@angular/forms';

export class GenericComponent {
	environment:any = environment;
	compModule: string;
	fileUp: any;
	id: number;
	complexForm: FormGroup;	
	urlFile: string;

	constructor(fb: FormBuilder){
		this.urlFile = environment.serverUrl + environment.urlFileView;
	}
}