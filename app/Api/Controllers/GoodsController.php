<?php

namespace App\Api\Controllers;

use App\Api\Forms\GoodsForm;
use App\Api\Models\ActivityIdiomsModel;
use App\Api\Models\CyModel;
use App\Common\Helpers\ResponseHelper;
use App\Api\Models\GoodsModel;
use Mix\Http\Message\Response;
use Mix\Http\Message\ServerRequest;

/**
 * Class UserController
 * @package App\Api\Controllers
 * @author liu,jian <coder.keda@gmail.com>
 */
class GoodsController
{

    /**
     * FileController constructor.
     * @param ServerRequest $request
     * @param Response $response
     */
    public function __construct(ServerRequest $request, Response $response)
    {
    }

    /**
     * Info
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function info(ServerRequest $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $content = ['code' => 0, 'message' => 'OK', 'data' => (new GoodsModel())->one($id)];
        return ResponseHelper::json($response, $content);
    } 

    /**
     * Create
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function create(ServerRequest $request, Response $response)
    {
        $form = new GoodsForm($request->getAttributes());
        $form->setScenario('create');
        if (!$form->validate()) {
            $content = ['code' => 1, 'message' => 'FAILED', 'data' => $form->getErrors()];
            return ResponseHelper::json($response, $content);
        }

        (new GoodsModel())->add($form);

        $content = ['code' => 0, 'message' => 'OK', 'data' => $form->attributes];
        return ResponseHelper::json($response, $content);
    }

    /**
     * actlong
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function actlong(ServerRequest $request, Response $response)
    {
        $gid = $request->getAttribute('gid');
        $nick = $request->getAttribute('nick');
        echo "\n gid : ". $gid. '=='. $nick ."\n";

        $activityIdiomsModel = new ActivityIdiomsModel();
        if (!$activityIdiomsModel->isExistGoodId($gid)) {
            return ResponseHelper::json($response, ["活动没准备好，请稍后再来 ！！！"]);
        }

        $row = $activityIdiomsModel->findOrderIdiomByMin($gid);

        if (count($row) == 0) {
            return ResponseHelper::json($response, ["活动数据没准备好，请稍后再来 ！！！"]);
        } 


        $row['buy_at'] = date('Y-m-d H:i:s');
        $row['nick'] = $nick;

        var_dump($row);

        $activityIdiomsModel->update($row);

        $content = ['code' => 0, 'message' => 'OK'];
        return ResponseHelper::json($response, $content);
    }

    /**
     * actlong
     * @param ServerRequest $request
     * @param Response $response
     * @return Response
     */
    public function createIdioms(ServerRequest $request, Response $response)
    {

        //todo 预览数据,上一个页面就把成语数据写进全局变量

        $id = $request->getAttribute('id');
        
        echo "\n good id is : ".$id."\n";
        $activityIdiomsModel = (new ActivityIdiomsModel);
        if ($activityIdiomsModel->isExistGoodId($id)) {
            return ResponseHelper::json($response, ["ok"]);
        }
               
        // var_dump($good);
        $cyModel = new CyModel();
        $itemS = $cyModel->randGetOne();

        $word = $itemS['name'];

        echo "\n first item start idiom is : ".$word."\n";
        $idiomResult = array();

        while (true) {
            $idiomResult = $this->generationIdiomLong($word, $cyModel);
            if (count($idiomResult) > 40) {
                break;
            }
        }
        

        echo "\n at last get : ";
        // var_dump($idiomResult);

        // $inArr[][] = array(array());
        // $now = date('Y-m-d H:i:s');
        $order = 1; 
        foreach ($idiomResult as $k => $item) {
            $inArr[] = ['good_id'=> $id, 'order'=>$order, 'word'=>$item];
            $order++;
        }
        // var_dump($inArr);
        $activityIdiomsModel->batchInsert($inArr);

        return ResponseHelper::json($response, $idiomResult);
    }

    
    private function generationIdiomLong(string $word, CyModel $cyModel) {
        $idiomResult[] = $word;
        $lastword = "";

        for ($i = 0; $i<100; $i++) {
            if (count($idiomResult) > 2) {
                $lastword = $idiomResult[count($idiomResult)-2];
            }

            // echo "\n last word : ".$lastword."\n";
            $finds = $this->getNextIdiom($lastword, $word, $cyModel);
            if ($finds[1] == "") {
                if (count($idiomResult) <= 2) {
                    break;
                }
                array_pop($idiomResult);
                $word = $lastword;
            } else {
                $word = $finds[1];
                $idiomResult[] = $word;
            }
        }

        return $idiomResult;
    }



    private function  getNextIdiom(string $lastword, string $word, CyModel $cyModel) {

        $wordE = mb_substr($word, -1, 1, "UTF-8");
        $currWord = $cyModel->findRandIdiomByWordS($wordE);
        if ($currWord == "") {
            return array($lastword, "");
        }
        return array($lastword, $currWord);
    }

}
