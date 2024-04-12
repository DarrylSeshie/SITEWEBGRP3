
export interface User {
    id_utilisateur: number; 
    civilite: string;        
    nom: string;             
    prenom: string;          
    email: string;           
    mot_de_passe: string;    
    gsm: string;             
    TVA?: string;            
    profession: string;     
    gsm_pro?: string;        
    email_pro?: string;      
    id_role: number;         
    id_institution?: number;  
    id_adresse: number;      
  }