<?php
namespace Asddaniel\UniversalLaravel\universal;
use Asddaniel\UniversalLaravel\Models\Colonne;
use Asddaniel\UniversalLaravel\Models\Donnee;
use Asddaniel\UniversalLaravel\Models\Enregistrement;
use Asddaniel\UniversalLaravel\Models\Relation;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use \Exception;

class UniversalModel{

  private $table_name;
  public function __construct(){

         $this->init_class_name();
         $this->migrate();
  }

  private function init_class_name(){
    $table = get_class($this);
    $table = explode("\\", $table);
    $this->table_name = strtolower($table[count($table)-1]);
  }
  private function get_property(){
    $table_name = $this->table_name;

    // dd($)
    return array_filter(array_keys(get_object_vars($this)), function($data){
        return $data!="table_name";
    });
  }

  protected function get_colonnes(){

    $donnees = Donnee::where("colonne_id", "=", -1)
        ->where("values", "=", $this->table_name)
        ->first();

    return $donnees!=null?$donnees->colonnes:[];

}

  private function init_table(){
    $donnees = Donnee::where("colonne_id", "=", -1)
    ->where("values", "=", $this->table_name)
    ->first();
    if($donnees==null){
        // dd($donnees);
       $donnees = Donnee::create(["colonne_id"=>-1, "values"=>$this->table_name]);
    }
    Session::put($this->table_name."_id", $donnees->id);
    return $donnees->id;
  }
  private function map_colonne($colonnes){
     return array_map(function($data){
            return $data["name"];
     }, $colonnes);
  }
  public static function create(array $array_data){
    // dd(get_called_class());
        $model = new (get_called_class())();
       $model->creer($array_data);
  }
  private function creer(array $data){
    $columns = $this->get_colonnes();
    $columns_id = Session::get("table__".$this->table_name);
    // dd($columns_id);
    if(count($data)<count($columns)){
        throw new Exception("Erreur vous devez donnez tous les propriétes", 1);

    }else{

        $record_id = $this->register_record();
     foreach ($data as $key => $value) {
        if(in_array($key, $this->get_property())){
         $id =  $this->register_data($value, $this->get_column_id($key));
         $this->register_relation($record_id, $id);
        }
     }
    }
  }
  private function register_relation($record_id, int $column_id){
      Relation::create(["origine"=>$record_id, "destination"=>$column_id]);
  }
  private function register_data($value, int $column_id){
  return  (Donnee::create(["colonne_id"=>$column_id, "values"=>$value]))->id;
  }
  private function get_column_id($col_name){
        $cols = Session::get("table__".$this->table_name);
        foreach ($cols as $key => $value) {
           if(array_key_exists($col_name, $value)) return $value[$col_name];
        }
        return null;
  }
  private function register_record(){
     return  (Enregistrement::create(["table_id"=>Session::get($this->table_name."_id")]))->id;
  }
  protected function get_array_ordererd_colonne(){
    $columns = [];
    foreach ($this->get_colonnes() as $key => $value) {

        $columns[$value["name"]] = $value["id"];
    }
    return $columns;
}
  public static function get(int $id){
    $data = new (get_called_class())();
   return (object) $data->get_one($id);
  }
  public static function all(){
    $data = new (get_called_class())();
   return (object) $data->get_all();
  }
  public static function delete(int $id){
    $data = new (get_called_class())();
    $data->supprimer($id);
  }
  public static function update(int $id, array $record){
    $data = new (get_called_class())();
    $data->update_line($id, $record);
  }

  private function update_line(int $id, array $data){
    $records = Enregistrement::where("table_id", "=", Session::get("table__".$this->table_name))
    ->get();
    if($records->count()>$id){
       $rel =  $records[$id]->relations;
    //    dd($rel);
        foreach ($data as $key => $value) {
             foreach ($rel as $cle => $valeur) {

                if($valeur->donnee->colonne->name==$key){
                    $valeur->donnee->update(["values"=>$value]);
                }
             }
        }

        return true;
    }else{
        return null;
    }
  }
  private function supprimer($id){
    $records = Enregistrement::where("table_id", "=", Session::get("table__".$this->table_name))
    ->get();
    // dd($records);
    if($records->count()>$id){
        $records[$id]->delete();
        return $this->delete_relation($records[$id]->id);
    }else{
        return null;
    }
  }

  private function delete_relation(int $record_id){
        $relations = Relation::where("origine", "=", $record_id)
         ->get();
         foreach ($relations as $key => $value) {
            $value->donnee->delete();
            $value->delete();
         }
  }

  protected function get_all(){
    $records = Enregistrement::where("table_id", "=", Session::get("table__".$this->table_name))
    ->get();
    $data = Donnee::where("colonne_id", ">", -1)
    ->get();
    $relations = Relation::all();
    // Session::put("_temp_data", $data);
    $donnees = [];
    Session::put("_temp_relations", $relations);
    foreach ($records as $key => $value) {
        array_push($donnees, (object) $this->map_offline_data($value->id));
    }
    return collect($donnees);
  }

  private function map_offline_data(int $record_id){
    Session::put("_temp_record_id", $record_id);

    $relations  =  (Session::get("_temp_relations"))->filter(function($data){

        return $data["origine"] == Session::get("_temp_record_id");
    });

    $data = [];

    //   dd($relations);
    foreach ($relations as $key => $value) {

        $data[($value->donnee->colonne->name)]=($value->donnee->values);
    }
    // dd($data);
      return $data;
  }
  protected function get_one($id){
    $records = Enregistrement::where("table_id", "=", Session::get("table__".$this->table_name))
    ->get();
    if($records->count()>$id){
        // dd($records[$id]->id);
        return $this->map_data($records[$id]->id);
    }else{
        return null;
    }
  }
  private function map_data( int $record_id){
    $relations  = Relation::where("origine", "=", $record_id)
                  ->get();

    $data = [];


    foreach ($relations as $key => $value) {

        $data[($value->donnee->colonne->name)]=($value->donnee->values);
    }
      return $data;
  }
  private function migrate(){
      $colonnes = $this->get_colonnes();
      $property = $this->get_property();
      $table_id = $this->init_table();
        //  dd($this->map_colonne([]));

      if(!empty(array_diff($property, $this->map_colonne(is_array($colonnes)?[]:$colonnes->toArray())))){
          $data = array_diff($property, $this->map_colonne(is_array($colonnes)?[]:$colonnes->toArray()));
         foreach ($data as $key => $value) {
            // echo $value;
          Colonne::create(["table_id"=>$table_id, "name"=>$value]);

         }
      }
      Session::put("table__".$this->table_name, array_map(function($data){
            return [$data["name"]=>$data["id"]];
      }, Colonne::where("table_id", "=", $table_id)->get()->toArray()));
  }

}
