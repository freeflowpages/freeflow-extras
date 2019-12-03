<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\freeflow_extras \controllers\space;

use humhub\components\Controller;
use humhub\modules\rest\definitions\UserDefinitions;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\User;
use humhub\modules\user\models\GroupUser;
use humhub\modules\user\models\Profile;
use humhub\modules\user\models\Auth;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\threebot_login\authclient\ThreebotAuth;
use humhub\modules\user\models\Invite;
use humhub\modules\space\models\Membership;
use humhub\modules\space\models\Space;
use Yii;
use yii\web\HttpException;
use Zend\Http\Request;
use Zend\Http\Client;
use yii\helpers\Json;

/**
 * Class AccountController
 */
class SpaceController extends Controller
{

    public function actionJoin($space)
    {
	    // Guest
        if(Yii::$app->user->isGuest){

                return $this->render('error', array('message' => "Login Required!"));
        }

        $user = Yii::$app->user;
	$space_name = $space;
	$space =  Space::findOne(['name' => str_replace("-","_",$space)]);

        if ($space === null) {
                throw new \yii\web\HttpException(404, "Space not found!");
        }


        $membership = Membership::findOne(['space_id' => $space -> id, 'user_id' => $user -> id]);
                if ($membership === null){
    
	     	    if ($space -> join_policy != 2){
                	throw new \yii\web\HttpException(403, "Space policy does not allow public join! Please contact Space admin!");
		    }

	            $membership = new Membership();
                    $membership -> space_id = $space -> id;
                    $membership -> user_id = $user -> id;
                    $membership -> status = Membership::STATUS_MEMBER;
                    $membership -> validate();
                    if (!$membership -> save()) {
                        return $this -> returnError(500, 'Internal error while adding user to space!');
                    }
                }


        $this->redirect(Yii::$app->urlManager->createAbsoluteUrl(['/s/' .  $space_name]));

    }
}
