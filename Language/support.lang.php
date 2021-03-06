<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 04.10.2019
 * Time: 17:46
 */

return array(
    'ru' => array(

        'support_ajax_empty_tid' => 'Не передан тикет ID',
        'support_ajax_empty_category' => 'Вам необходимо выбрать «Категорию» обращения',
        'support_ajax_empty_details' => 'Не переданы детали сообшения',
        'support_ajax_empty_title' => 'Не передана Тема обращения',
        'support_ajax_empty_message' => 'Не передана Описания обращения или Комментарий',

        'title_awaiting_user' => 'Ожидают ответа',
        'title_awaiting_admin' => 'Обрабатываются',
        'title_closed' => 'Закрытые',
        'title_msg_empty' => 'Сообщений нет',

        'tabs_all_ticket' => 'Все обращения',
        'tabs_create_ticket' => 'Создать тикет',

        'btn_create_ticket_1' => 'Создать тикет',
        'btn_create_ticket_2' => 'Общие вопросы',

        'btn_create_donate_1' => 'Проблемы',
        'btn_create_donate_2' => 'с донатом',

        'btn_create_lost_1' => 'Пропали',
        'btn_create_lost_2' => 'предметы',

        'title_create_ticket' => 'Создать новый тикет в указанный департамент',

        'title_create_category_6' => 'Пропажа предметов',
        'title_create_category_7' => 'Жалоба на бота',
        'title_create_category_8' => 'Проблемы с пополнением баланса',



        'form_title_category' => 'Категория',
        'form_title_account' => 'Аккаунт',
        'form_title_char' => 'Персонаж',
        'form_title_char_select' => 'Выберите персонажа',
        'error_account_char_not_found' => 'На этом аккаунте нет персонажей',
        'form_title_title' => 'Тема',
        'form_title_title_text' => 'Укажите тему сообщения',
        'form_title_title_files' => 'Прикрепить изображения
            <div style="font-size: 0.8em;">Общий размер не превышает 2&nbsp;МБ</div>
            <div style="font-size: 0.8em;">В формате JPG, GIF или PNG</div>',

        //Пропал предмет
        'form_title_sharing' => 'Был ли доступ у других игроков к вашему аккаунту?',
        'form_title_yse' => 'Да',
        'form_title_yse_text' => 'Внимание, если у других игроков был санкционированный Вами доступ к аккаунту, то украденные предметы возвращены не будут. В этом случае возможно проведение расследование и сообщение результата вам. Стоимость услуги - индивидуально',
        'form_title_no' => 'Нет',
        'form_title_no_text' => 'Внимание, если в результате расследования будет выяснено, что к аккаунту имели санкционированный Вами доступ другие игроки, то этот факт будет воспринят как попытка обмануть администрацию. В этом случае вам грозит блокировка игрового аккаунта согласно установленным правилам.',
        'form_title_protection' => 'Была ли включена защита аккаунта?',
        'form_title_loss' => 'Примерная дата пропажи',
        'form_title_contact' => 'Способ связи',
        'form_title_message_loss' => 'Укажите список пропавших предметов',
        'form_title_message_loss_desc' => 'Пропал магический меч',

        //проблема с платежом
        'form_title_payment_method' => 'Выберите платежную систему',
        'form_title_transactions' => 'Номер заказа или транзакции',
        'form_title_pay_date' => 'Дата платежа',
        'form_title_pay_time' => 'Время платежа',
        'form_title_sum' => 'Сумма платежа',
        'form_title_message_comment' => 'Комментарий',
        'form_title_message_comment_text' => 'Комментарий...',


        //найден бот
        'form_title_date' => 'Дата обнаружения нарушителя',
        'form_title_time' => 'Время',
        'form_title_bot_name' => 'Перечислите никнеймы нарушителей',
        'form_title_message_bot' => 'Комментарий, ссылка на скриншоты...',



        'form_title_message' => 'Сообщение',
        'form_title_message_text' => 'Описание проблемы...',




        'form_title_send_btn' => 'Отправить',



        'category' => array(
            //0 => 'Выберите категорию',
            1 => 'Общие вопросы',
            2 => 'Сайт, Форум, ЛК',
            3 => 'Ошибки клиента',
            4 => 'Ошибки игры',
            5 => 'Блокировка аккаунта/персонажа',
            6 => 'Пропажа предметов',
            7 => 'Жалоба на бота',
            8 => 'Проблемы с пополнением баланса',
            9 => 'Прочее',
        ),

    ),
    'en' => array(
	
        'support_ajax_empty_tid' => 'Invalid ticket ID specified',
        'support_ajax_empty_category' => 'You need to select a ticket topic',
        'support_ajax_empty_details' => 'You need to provide the ticket details',
        'support_ajax_empty_title' => 'Please enter a valid subject',
        'support_ajax_empty_message' => 'Please enter a valid message',

        'title_awaiting_user' => 'Awaiting Response',
        'title_awaiting_admin' => 'Being Processed',
        'title_closed' => 'Closed',
        'title_msg_empty' => 'No tickets',

        'tabs_all_ticket' => 'All tickets',
        'tabs_create_ticket' => 'Create ticket',

        'btn_create_ticket_1' => 'Other',
        'btn_create_ticket_2' => 'Other issues & questions',

        'btn_create_donate_1' => 'Donation Issues',
        'btn_create_donate_2' => 'Issues related to donations',

        'btn_create_lost_1' => 'Item Loss',
        'btn_create_lost_2' => 'Issues related to loss of in-game items',

        'title_create_ticket' => 'Create a new ticket',

        'title_create_category_6' => 'Item Loss',
        'title_create_category_7' => 'Bot Report',
        'title_create_category_8' => 'Issues with Balance Top-ups',



        'form_title_category' => 'Topic',
        'form_title_account' => 'Game Account',
        'form_title_char' => 'Character',
        'form_title_char_select' => 'Choose a character',
        'error_account_char_not_found' => 'There are no characters on this game account.',
        'form_title_title' => 'Subject',
        'form_title_title_text' => 'Specify the subject of your ticket',
        'form_title_title_files' => 'Attach images
            <div style="font-size: 0.8em;">The total file size cannot exceed 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">JPG, GIF or PNG format accepted</div>',

        //Пропал предмет
        'form_title_sharing' => 'Did other players have access to your account?',
        'form_title_yse' => 'Yes',
        'form_title_yse_text' => 'ATTENTION: If other players knowingly had access to your account, then stolen items will NOT be recovered. In cases like these, it is only possible to conduct an investigation and provide you with details on who accessed and when they accessed your account. This is a chargeable service and the price is per character.',
        'form_title_no' => 'No',
        'form_title_no_text' => 'ATTENTION: If following the investigation it is determined that other players knowingly had access to your account, then the intentionally wrongful response provided to this question will be considered as an attempt in deceiving the administration. In this case, your account will be banned in accordance with the established User Agreement.',
        'form_title_protection' => 'Have you enabled PIN-Code?',
        'form_title_loss' => 'Estimated date of item loss',
        'form_title_contact' => 'Communication method',
        'form_title_message_loss' => 'Specify a list of missing items',
        'form_title_message_loss_desc' => 'My Sword of Miracles is gone!',

        //проблема с платежом
        'form_title_payment_method' => 'Choose a Payment Method',
        'form_title_transactions' => 'Order or Transaction Number',
        'form_title_pay_date' => 'Payment Date',
        'form_title_pay_time' => 'Payment Time',
        'form_title_sum' => 'Payment Amount',
        'form_title_message_comment' => 'Details',
        'form_title_message_comment_text' => 'Details...',


        //найден бот
        'form_title_date' => 'Suspect Detection Date',
        'form_title_time' => 'Time',
        'form_title_bot_name' => 'Suspected Character Names',
        'form_title_message_bot' => 'Details, link to screenshots/videos',



        'form_title_message' => 'Message',
        'form_title_message_text' => 'Question/problem details...',




        'form_title_send_btn' => 'Submit',



        'category' => array(
            //0 => 'Choose subject',
            1 => 'General Questions',
            2 => 'Website, Forum, Master Account',
            3 => 'Client Errors',
            4 => 'Game Bugs',
            5 => 'Account/Character Ban',
            6 => 'Item Loss',
            7 => 'Bot Report',
            8 => 'Issues with Balance Top-ups',
            9 => 'Other',
        ),
	
	
	
    ),
    'gr' => array(
	
        'support_ajax_empty_tid' => 'Λανθασμένο ID αιτήματος υποστήριξης',
        'support_ajax_empty_category' => 'Πρέπει να επιλέξετε θέμα αιτήματος υποστήριξης',
        'support_ajax_empty_details' => 'Πρέπει να εισάγετε τις λεπτομέρειες του αιτήματος υποστήριξης',
        'support_ajax_empty_title' => 'Εισάγετε ένα έγκυρο τίλτο',
        'support_ajax_empty_message' => 'Εισάγετε ένα έγκυρο μήνυμα',

        'title_awaiting_user' => 'Αναμένουν Απάντηση',
        'title_awaiting_admin' => 'Σε Επεξεργασία',
        'title_closed' => 'Κλειστά',
        'title_msg_empty' => 'Κανένα αίτημα',

        'tabs_all_ticket' => 'Όλα τα αιτήματα',
        'tabs_create_ticket' => 'Υποβολή αιτήματος',

        'btn_create_ticket_1' => 'Άλλα',
        'btn_create_ticket_2' => 'Άλλα προβλήματα και ερωτήσεις',

        'btn_create_donate_1' => 'Προβλήμα με Δωρεά',
        'btn_create_donate_2' => 'Προβλήματα που σχετίζονται με τις δωρεές',

        'btn_create_lost_1' => 'Απώλεια Item',
        'btn_create_lost_2' => 'Προβλήματα που σχετίζονται με την απώλεια in-game items',

        'title_create_ticket' => 'Υποβολή νέου αιτήματος',

        'title_create_category_6' => 'Απώλεια Item',
        'title_create_category_7' => 'Αναφορά Bot',
        'title_create_category_8' => 'Πρόβλημα με Ανανέωση Υπολοίπου',



        'form_title_category' => 'Κατηγορία',
        'form_title_account' => 'Game Account',
        'form_title_char' => 'Χαρακτήρας',
        'form_title_char_select' => 'Επιλέξτε χαρακτήρα',
        'error_account_char_not_found' => 'Δεν υπάρχουν χαρακτήρες σε αυτό το game account.',
        'form_title_title' => 'Θέμα',
        'form_title_title_text' => 'Καθορίστε το θέμα του αιτήματός σας',
        'form_title_title_files' => 'Επισύναψη εικόνων
            <div style="font-size: 0.8em;">Το συνολικό μέγεθος δεν μπορεί να ξεπερνάει τα 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">Αποδεκτές μορφές: JPG, GIF ή PNG</div>',

        //Пропал предмет
        'form_title_sharing' => 'Είχε κάποιος άλλος παίκτης πρόσβαση στο account σας;',
        'form_title_yse' => 'Ναί',
        'form_title_yse_text' => 'ΠΡΟΣΟΧΗ: Εάν άλλοι παίκτες είχαν πρόσβαση στο account σας εν γνώσει σας, τότε τα κλεμμένα items ΔΕΝ θα επιστραφούν. Σε τέτοιες περιπτώσεις, το μόνο που μπορούμε να σας προσφέρουμε είναι να ελέγξουμε το ιστορικό και να σας δώσουμε πληροφορίες σχετικά με το πότε και ποίος συνδέθηκε στο account. Αυτό είναι μία χρεώσιμη υπηρεσία της οποίας η τιμή είναι ανά χαρακτήρα.',
        'form_title_no' => 'Όχι',
        'form_title_no_text' => 'ΠΡΟΣΟΧΗ: Εάν ύστερα από έλεγχο διαπιστωθεί ότι άλλοι παίκτες είχαν πρόσβαση στο account σας εν γνώσει σας, τότε η εκ προθέσεως λανθασμένη απάντηση σας σε αυτή την ερώτηση θα θεωρηθεί ως απόπειρα απάτης σε βάρος της διαχείρησης. Σε αυτή την περίπτωση, το account σας θα αποκλειστεί βάσει των ισχυόντων Όρων Χρήσης.',
        'form_title_protection' => 'Έχετε ενεργοποιήσει το PIN-Code;',
        'form_title_loss' => 'Εκτιμώμενη ημερομηνία απώλειας item',
        'form_title_contact' => 'Τρόπος επικοινωνίας',
        'form_title_message_loss' => 'Ορίστε μια λίστα με τα items που λείπουν',
        'form_title_message_loss_desc' => 'Το Sword of Miracles μου χάθηκε!',

        //проблема с платежом
        'form_title_payment_method' => 'Επιλέξτε Σύστημα Πληρωμών',
        'form_title_transactions' => 'Αριθμός Παραγγελίας ή Συναλλαγής',
        'form_title_pay_date' => 'Ημερομηνία πληρωμής',
        'form_title_pay_time' => 'Ώρα πληρωμής',
        'form_title_sum' => 'Ποσό πληρωμής',
        'form_title_message_comment' => 'Λεπτομέρειες',
        'form_title_message_comment_text' => 'Λεπτομέρειες...',


        //найден бот
        'form_title_date' => 'Ημερομηνία Εντοπισμού Υπόπτου',
        'form_title_time' => 'Ώρα',
        'form_title_bot_name' => 'Ονόματα Ύποπτων Χαρακτήρων',
        'form_title_message_bot' => 'Λεπτομέρειες, link σε screenshots/videos',



        'form_title_message' => 'Μήνυμα',
        'form_title_message_text' => 'Περιγραφή ερώτησης/προβλήματος...',




        'form_title_send_btn' => 'Υποβολή',



        'category' => array(
            //0 => 'Choose subject',
            1 => 'Γενικές Ερωτήσεις',
            2 => 'Website, Forum, Master Account',
            3 => 'Προβλήματα Client',
            4 => 'Game Bugs',
            5 => 'Αποκλεισμός Account/Χαρακτήρα',
            6 => 'Απώλεια Item',
            7 => 'Αναφορά Bot',
            8 => 'Προβλήματα με Ανανεώση Υπολοίπου',
            9 => 'Άλλα',
        ),
	
	
	
	),
	'es' => array(
	
        'support_ajax_empty_tid' => 'ID de ticket especificado inválido',
        'support_ajax_empty_category' => 'Debes elegir un tema de ticket',
        'support_ajax_empty_details' => 'Debes proveer los detalles del ticket',
        'support_ajax_empty_title' => 'Por favor ingresa un asunto válido',
        'support_ajax_empty_message' => 'Por favor ingresa un mensaje válido',

        'title_awaiting_user' => 'Esperando Respuesta',
        'title_awaiting_admin' => 'Siendo procesado',
        'title_closed' => 'Cerrado',
        'title_msg_empty' => 'No hay tickets',

        'tabs_all_ticket' => 'Todos los tickets',
        'tabs_create_ticket' => 'Crear ticket',

        'btn_create_ticket_1' => 'Otros',
        'btn_create_ticket_2' => 'Otros problemas y consultas',

        'btn_create_donate_1' => 'Problemas de Donaciones',
        'btn_create_donate_2' => 'Problemas relacionados con donaciones',

        'btn_create_lost_1' => 'Pérdida de Artículos',
        'btn_create_lost_2' => 'Problemas relacionados con la pérdida de artículos dentro del juego',

        'title_create_ticket' => 'Crear un nuevo ticket',

        'title_create_category_6' => 'Pérdida de Artículos',
        'title_create_category_7' => 'Reporte de Bot',
        'title_create_category_8' => 'Problemas con recargas de Saldo',



        'form_title_category' => 'Tema',
        'form_title_account' => 'Cuenta de Juego',
        'form_title_char' => 'Personaje',
        'form_title_char_select' => 'Selecciona un personaje',
        'error_account_char_not_found' => 'No hay personajes en esta cuenta de juego.',
        'form_title_title' => 'Tema',
        'form_title_title_text' => 'Especifica el tema de tu ticket',
        'form_title_title_files' => 'Adjunta imágenes
            <div style="font-size: 0.8em;">El tamaño total del archivo no puede exceder de 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">Formatos aceptados: JPG, GIF or PNG</div>',

        //Пропал предмет
        'form_title_sharing' => 'Otros jugadores han tenido acceso a tu cuenta?',
        'form_title_yse' => 'Sí',
        'form_title_yse_text' => 'ATENCIÓN: Si otros jugadores tuvieron acceso a tu cuenta a sabiendas, los artículos robados NO se recuperarán. En casos como estos, solo es posible llevar a cabo una investigación y proporcionarte detalles sobre quién accedió y cuándo accedió a tu cuenta. Este es un servicio pago y el precio es por personaje.',
        'form_title_no' => 'No',
        'form_title_no_text' => 'ATENCIÓN: Si siguiendo la investigación se determina que otros jugadores tenían acceso a tu cuenta a sabiendas, entonces, la respuesta intencionalmente ilícita proporcionada a esta pregunta se considerará un intento de engañar a la administración. En este caso, tu cuenta será prohibida de acuerdo con lo establecido en el Acuerdo de Usuario.',
        'form_title_protection' => 'Has habililitado el Código-PIN?',
        'form_title_loss' => 'Fecha estimada de la pérdida de los artículos',
        'form_title_contact' => 'Método de comunicación',
        'form_title_message_loss' => 'Especifica una lista de los artículos faltantes',
        'form_title_message_loss_desc' => 'Mi Sword of Miracles ha desaparecido!',

        //проблема с платежом
        'form_title_payment_method' => 'Elige un Método de Pago',
        'form_title_transactions' => 'Número de Orden o Transacción',
        'form_title_pay_date' => 'Fecha de Pago',
        'form_title_pay_time' => 'Hora de Pago',
        'form_title_sum' => 'Monto de Pago',
        'form_title_message_comment' => 'Detalles',
        'form_title_message_comment_text' => 'Detalles...',


        //найден бот
        'form_title_date' => 'Fecha de Detección del Sospechoso',
        'form_title_time' => 'Hora',
        'form_title_bot_name' => 'Nombres de los Personajes Sospechos',
        'form_title_message_bot' => 'Detalles, vínculos a capturas de pantalla/videos',



        'form_title_message' => 'Mensaje',
        'form_title_message_text' => 'Detalles de la pregunta/problema...',




        'form_title_send_btn' => 'Enviar',



        'category' => array(
            //0 => 'Choose subject',
            1 => 'Preguntales Generales',
            2 => 'Sitio Web, Foro, Cuenta Maestra',
            3 => 'Errores del Cliente',
            4 => 'Errores del juego',
            5 => 'Ban de Cuenta/Personaje',
            6 => 'Pérdida de Artículos',
            7 => 'Reporte de Bot',
            8 => 'Problemas con Recargas de Saldo',
            9 => 'Otros',
        ),
	
	
	
    ),
    'pt' => array(
    
        'support_ajax_empty_tid' => 'ID de ticket inválido especificado ',
        'support_ajax_empty_category' => 'Você precisa selecionar um tópico de ticket',
        'support_ajax_empty_details' => 'Você precisa fornecer os detalhes do ticket',
        'support_ajax_empty_title' => 'Por favor insira um assunto válido',
        'support_ajax_empty_message' => 'Por favor insira uma mensagem válida',

        'title_awaiting_user' => 'Esperando resposta',
        'title_awaiting_admin' => 'Sendo processado',
        'title_closed' => 'Fechado',
        'title_msg_empty' => 'Sem tickets',

        'tabs_all_ticket' => 'Todos os tickets',
        'tabs_create_ticket' => 'Criar um ticket',

        'btn_create_ticket_1' => 'Outro',
        'btn_create_ticket_2' => 'Outros problemas e questões',

        'btn_create_donate_1' => 'Problemas de doação',
        'btn_create_donate_2' => 'Questões relacionadas a doações',

        'btn_create_lost_1' => 'Perda de item',
        'btn_create_lost_2' => 'Problemas relacionados à perda de itens do jogo',

        'title_create_ticket' => 'Criar um novo ticket',

        'title_create_category_6' => 'Perda de item',
        'title_create_category_7' => 'Denúncia de Bot',
        'title_create_category_8' => 'Problemas com recargas de saldo',

        'form_title_category' => 'Tópico',
        'form_title_account' => 'Conta do jogo',
        'form_title_char' => 'Personagem',
        'form_title_char_select' => 'Escolha o personagem',
        'error_account_char_not_found' => 'Não há personagens nesta conta de jogo.',
        'form_title_title' => 'Assunto',
        'form_title_title_text' => 'Especifique o assunto do seu ticket',
        'form_title_title_files' => 'Anexar imagens
            <div style="font-size: 0.8em;">O tamanho total do arquivo não pode exceder 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">Formatos JPG, GIF ou PNG aceitos</div>',

        //Пропал предмет
        'form_title_sharing' => 'Outros jogadores tiveram acesso à sua conta?',
        'form_title_yse' => 'Sim',
        'form_title_yse_text' => 'ATENÇÃO: Se outros jogadores intencionalmente tiveram acesso à sua conta, os itens roubados NÃO serão recuperados. Em casos como esse, só é possível conduzir uma investigação e fornecer detalhes sobre quem acessou e quando acessou sua conta. Este é um serviço pago e o preço é por personagem.',
        'form_title_no' => 'Não',
        'form_title_no_text' => 'ATENÇÃO: Se após a investigação for determinado que outros jogadores intencionalmente tiveram acesso à sua conta, a resposta intencionalmente errada fornecida a esta questão será considerada uma tentativa de enganar a administração. Neste caso, sua conta será banida de acordo com o Acordo de Usuário estabelecido.',
        'form_title_protection' => 'Você habilitou o código PIN?',
        'form_title_loss' => 'Data estimada de perda do item',
        'form_title_contact' => 'Método de comunicação',
        'form_title_message_loss' => 'Especifique uma lista de itens perdidos',
        'form_title_message_loss_desc' => 'Minha Sword of Miracles foi levada!',

        //проблема с платежом
        'form_title_payment_method' => 'Escolha um método de pagamento',
        'form_title_transactions' => 'Pedido ou número de transação',
        'form_title_pay_date' => 'Data do pagamento',
        'form_title_pay_time' => 'Hora do pagamento',
        'form_title_sum' => 'Valor de Pagamento',
        'form_title_message_comment' => 'Detalhes',
        'form_title_message_comment_text' => 'Detalhes...',

        //найден бот
        'form_title_date' => 'Data de detecção suspeita',
        'form_title_time' => 'Hora',
        'form_title_bot_name' => 'Nomes de personagens suspeitos',
        'form_title_message_bot' => 'Detalhes, link para capturas de tela/vídeos',

        'form_title_message' => 'Mensagem',
        'form_title_message_text' => 'Detalhes da pergunta/problema...',


        'form_title_send_btn' => 'Enviar',


        'category' => array(
            //0 => 'Choose subject',
            1 => 'Questões gerais',
            2 => 'Website, Forum, Conta Mestre',
            3 => 'Erros no cliente do jogo',
            4 => 'Bugs do jogo',
            5 => 'Banimento de conta/personagem ',
            6 => 'Perda de item',
            7 => 'Denúncia de bot',
            8 => 'Problemas com recargas de saldo',
            9 => 'Outros',
        ),
    
    
    ),
);