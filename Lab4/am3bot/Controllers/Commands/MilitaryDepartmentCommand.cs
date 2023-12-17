using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{

        public class MilitaryDepartmentCommand : ICommand
        {
            public TelegramBotClient Client => Bot.GetTelegramBot().Result;

            public string Name => "Військова кафедра🐶";

            public async Task Execute(Update update)
            {
                long chatId = update.Message.Chat.Id;


                await Client.SendTextMessageAsync(
                    chatId,
                    text: "Present🧑‍🚀");


            }
    }
}
