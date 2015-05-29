<?php

class TechnologiesSeeder extends Seeder {

    public function run()
	{
        //Technology::truncate();
        $path = 'img/technology/';
        $tech = Technology::create([
        'name'=>'Aerotec-Beam System',
        'shortname'=>'ABS',
        'description'=>'    Использование передовых вычислительных систем позволяет изготавливать ракетки с экстремально низким сопротивлением воздуха и высокой мощью, чтобы в самом широком диапазоне обеспечить результативность игрока. Благодаря аэродинамической конструкции ракетки подходят игрокам различных стилей. Система Aerotec-Beam System от LiNing создана в результате сбора данных длительного жесткого тестирования при разных стилях игры',
        'logo'=> $path.'aerotec_beam_system.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
    
    $tech = Technology::create([
        'name'=>'HDF - Shock Absoprtion System',
        'shortname'=>'HDF',
        'description'=>'    Ободы ракеток заполнены высокотехнологичными легкими амортизирующими материалами для улучщения выполнения смеша и снижения риска травм. Материалы HDF-Shock Absoprtion System, заполняющие обод ракеток, разработаны при помощи высоких технологий для амортизации и уменьшения отдачи от удара в кисть и плечо. Таким образом снижается риск травм при движении без ущерба результативности. Это легкие и гибкие материалы нового поколения.',
        'logo'=> $path.'hdf.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
    
    $tech = Technology::create([
        'name'=>'Dynamic-Optimum Frame',
        'shortname'=>'DOF',
        'description'=>'Dynamic-Optimum Frame description',
        'logo'=> $path.'dynamic_optimum_frame.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
    
    $tech = Technology::create([
        'name'=>'Wing Stabilizer',
        'shortname'=>'WS',
        'description'=>'Wing Stabilizer description',
        'logo'=> $path.'wing.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
    
    $tech = Technology::create([
        'name'=>'MPCF Reinforcing Technology',
        'shortname'=>'MPDF',
        'description'=>'MPCF Reinforcing Technology description',
        'logo'=> $path.'mpdf.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
    
    $tech = Technology::create([
        'name'=>'TB Nano Powertec',
        'shortname'=>'TB Nano',
        'description'=>'TB Nano Powertec description',
        'logo'=> $path.'tb_nano.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
    
    $tech = Technology::create([
        'name'=>'AirStream System',
        'shortname'=>'AS',
        'description'=>'AirStream System description',
        'logo'=> $path.'as.jpg'
            ]);
        $tech->goods()->attach([3]);
        
    $tech = Technology::create([
        'name'=>'3D Break Free',
        'shortname'=>'3D BF',
        'description'=>'3D Break Free description',
        'logo'=> $path.'3d_breakfree.jpg'
            ]);
        $tech->goods()->attach([4]);
        
    $tech = Technology::create([
        'name'=>'Bio Inner Cone',
        'shortname'=>'BIC',
        'description'=>'Bio Inner Cone description',
        'logo'=> $path.'bio_inner_cone.jpg'
            ]);
        $tech->goods()->attach([1,2,3,4]);
        
    $tech = Technology::create([
        'name'=>'TuffOS',
        'shortname'=>'TuffOS',
        'description'=>'    Ультраустойчивый синтетический материал увеличивает износостойкость более, чем в 5 раз, по сравнению с обычной резиной.',
        'logo'=> $path.'tuffos.jpg'
            ]);
            
    } 
}        