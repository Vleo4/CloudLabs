using Telegram.Bot.Types.ReplyMarkups;
using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{
    public class ExitCommand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;

        public string Name => "Exit🌚";


        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;

            await Client.SendTextMessageAsync(
            chatId,
            text: "Goodbye... \nThanks for using my bot🤟 ",
            replyMarkup: new ReplyKeyboardRemove());
        }



    }
}
